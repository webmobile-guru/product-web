import { Component, OnInit, Output, EventEmitter, Inject, PLATFORM_ID } from '@angular/core';
import { Property } from '../model/property';
import { Subscription } from 'rxjs';
import { ActivatedRoute, Params, Router } from '@angular/router';
import { SearchStateService } from './search-state.service';
import { Location } from '../../location/location/location';
import { AgentService } from '../../agent/agent.service';
import { isPlatformServer } from '@angular/common';
import { Title, Meta } from '@angular/platform-browser';
import { LinkService } from '../../components/links/LinkService';
import { sortingOptions } from '../globals';

@Component({
  selector: 'app-property-search',
  templateUrl: './property-search.component.html',
  styleUrls: ['./property-search.component.css'],
  providers: [LinkService]
})
export class PropertySearchComponent implements OnInit {
  @Output() setLocationToSearchHederComponent = new EventEmitter<any>();

  properties: Property[] = [];
  subscription: Subscription;
  location: Location;
  queryResultLocation: object;
  querySearch = '';
  queryState: any = [];
  locationValue: any = '';
  resultSlug: any = '';

  constructor(
    private route: ActivatedRoute,
    private searchStateService: SearchStateService,
    public agentService: AgentService,
    private router: Router,
    private title: Title,
    private meta: Meta,
    private linkService: LinkService,
    @Inject(PLATFORM_ID) private platformId
  ) {}

  ngOnInit() {
    this.searchStateService.setSortedValue(this.searchStateService.sortBy);

    this.getProperties();
    if (!isPlatformServer(this.platformId)) {
      // If not the server
      window.scrollTo(0, 0);
    }
  }

  getProperties() {
    this.route.queryParams.subscribe((val) => {
      // Update title
      let titleString = '';
      if (val.bedrooms !== undefined) {
        if (val.bedrooms === 0) {
          titleString = 'Studios ';
        } else {
          titleString = val.bedrooms + ' Bedroom ';
        }
      }
      if (val.unitType !== undefined) {
        if (val.unitType === 'STAFF_ACCOMODATION' || val.unitType === 'LAND') {
          titleString += val.unitType
            .split('_')
            .join(' ')
            .toLowerCase()
            .replace(/\b([a-z])/g, (a) => a.toUpperCase());
        } else {
          titleString += (val.unitType + 's')
            .split('_')
            .join(' ')
            .toLowerCase()
            .replace(/\b([a-z])/g, (a) => a.toUpperCase());
        }
        titleString += ' ';
      } else {
        titleString += 'Properties ';
      }
      if (val.listingType !== undefined) {
        switch (val.listingType) {
          case 'SALE':
          case 'COMMERCIAL_SALE':
            titleString += 'for Sale in ';
            break;
          case 'RENT':
          case 'COMMERCIAL_RENT':
            titleString += 'for Rent in ';
            break;
          default:
            titleString += ' in ';
            break;
        }
      }
      if (val.locations) {
        const locs = val.locations.split(',');
        let mainLocation = locs[0];
        mainLocation = mainLocation.split('-').join(' ');
        mainLocation = mainLocation.replace(/\b([a-z])/g, (a) => a.toUpperCase());
        titleString += mainLocation;
      } else {
        titleString += 'UAE';
      }

      titleString += ' | houhaa';
      this.title.setTitle(titleString);
      // Don't follow on these pages
      this.meta.updateTag({
          name: 'robots', content: 'noindex,nofollow'},
        `name='robots'`);
      // Remove description tag
      this.meta.removeTag(`name='description'`);
      // Remove canonical link
      this.linkService.removeTag('rel=canonical');
      this.linkService.removeTag('rel=alternate');

      this.queryState = JSON.stringify(val);
      const sortedQuery = { ...val, sort: this.searchStateService.sortBy };

      const changed = this.searchStateService.setSearchParams(sortedQuery);
      this.subscription = this.searchStateService.getProperties().subscribe((properties) => {
        this.properties = properties;
      });

      this.searchStateService.getLocation().subscribe((location) => {
        this.location = location;
      });
      if (changed) {
        this.searchStateService.searchProperties();
      } else {
        this.searchStateService.resumeProperties();
      }
      // Calculate the search parameters without the location
      // to create links for the child locations
      this.queryResultLocation = this.searchParamsWithoutLocation(val);
    });
  }

  searchParamsWithoutLocation(params: Params): object {
    const newParams: { [k: string]: any } = {};
    for (const param in params) {
      if (param !== 'locations') {
        newParams[param] = params[param];
      }
    }
    return newParams;
  }

  searchParamsWithLocation(location: string): object {
    const newParams = { ...this.queryResultLocation };
    newParams['locations'] = location;
    return newParams;
  }

  setSearchPropertyData(query) {
    this.router.navigateByUrl('en/search?' + query);
    this.getProperties();
  }

  setLocationToResultLocationArray(e) {
    this.locationValue = e;
  }

  resultLocationSlug(e) {
    this.resultSlug = e;
  }

  updateSortingQuery(e) {
    this.searchStateService.setSortedValue(e.value);
    this.getProperties();
  }

}
