import { Component, OnInit, Output, EventEmitter } from '@angular/core';
import { ActivatedRoute, Params, Router } from '@angular/router';
import { SearchStateService } from '../property-search/search-state.service';
import { Subscription, empty } from 'rxjs';
import { Property } from '../model/property';
import { Location } from '../../location/location/location';
import * as $ from '../../../assets/js/vendor/jquery-3.4.1.js';
import { Title, Meta } from '@angular/platform-browser';
import { LinkService } from '../../components/links/LinkService';
import { sortingOptions } from '../globals';

@Component({
  selector: 'app-property-search-shortcut',
  templateUrl: '../property-search/property-search.component.html',
  styleUrls: ['./property-search-shortcut.component.css'],
  providers: [LinkService],
})
export class PropertySearchShortcutComponent implements OnInit {
  @Output() setLocationToSearchHederComponent = new EventEmitter<any>();
  resultSlug: any = '';
  subscription: Subscription;
  properties: Property[] = [];
  location: Location;
  queryResultLocation: object;
  queryState: any = {};
  locationValue: any = '';

  constructor(
    private route: ActivatedRoute,
    private searchStateService: SearchStateService,
    private router: Router,
    private title: Title,
    private meta: Meta,
    private linkService: LinkService,
  ) { }

  ngOnInit() {
    this.route.params.subscribe((val) => {
      this.buildSearch();
      this.subscription = this.searchStateService.getProperties().subscribe((properties) => {
        this.properties = properties;
      });
      this.searchStateService.getLocation().subscribe((resLocations) => {
        this.location = resLocations;
      });

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

  buildSearch(): void {
    const search = {};
    this.queryState = {};

    // Version 2 has 2 options

    // :lang/:section/:typeLocation
    // :lang/:section/:location/:typeLocation

    // lang = en can ignore for now
    // section = rent, buy, commercial-rent commercial-sale
    // location if exists is a level 1 location
    // typeLocation has various parts
    //
    // Part 1, basic just the search as is
    // - properties-for-rent
    // - properties-for-sale
    //
    // Part 2, adds type of property
    // - apartments-for-rent
    // - villas-for-sale
    //
    // Part 3, adds bedrooms
    // - 3-bedroom-villas-for-sale
    // - studio-apartments-for-rent
    //
    // Part 4, adds neighbourhood
    // - 3-bedroom-villas-for-sale-deema-1
    // - studio-apartments-for-rent-dubai-marina
    //
    // Part 5, can also be prefixed short-term
    // - short-term-apartments-for-rent
    // - short-term-studio-apartments-for-rent-dubai-marina

    const section = this.route.snapshot.paramMap.get('section');
    const location = this.route.snapshot.paramMap.get('location');
    let typeLocation = this.route.snapshot.paramMap.get('typeLocation');
    // let urlParts = this.route.snapshot.paramMap.get('area').split('?');
    // const area = urlParts[0];
    console.log('section', section);
    console.log('location', location);
    console.log('typeLocation', typeLocation);

    switch (section) {
      case 'rent':
        search['listingType'] = 'RENT';
        break;
      case 'buy':
        search['listingType'] = 'SALE';
        break;
      case 'commercial-rent':
        search['listingType'] = 'COMMERCIAL_RENT';
        break;
      case 'commercial-sale':
        search['listingType'] = 'COMMERCIAL_SALE';
      break;
    }
    // Need to break down area
    // apartments-for-rent-dubai-marina
    // villas-for-sale-the-lakes
    // 1-bedroom-apartments-for-sale-dubai-marina
    // first word for property type

    const isShortTerm = typeLocation.split('short-term-').length > 1;
    if (isShortTerm) {
      typeLocation = typeLocation.split('short-term-')[1];
      search['rentalLength'] = 'MONTHLY';
    }

    let parts = typeLocation.split('-');
    let title = '';
    let description = 'Search ';
    if (parts[0] === 'studios') {
      search['bedrooms'] = 0;
      parts = parts.slice(1);
      title = 'Studio ';
      description += 'Studio ';
    }
    if (parts[1] === 'bedroom') {
      title = `${parts[0]} Bedroom `;
      description += `${parts[0]} Bedroom `;
      search['bedrooms'] = parts[0];
      parts = parts.slice(2);
    }
    if (parts[0] === 'apartments') {
      search['unitType'] = 'APARTMENT';
      title += 'Apartments ';
      description += 'Apartments ';
    } else if (parts[0] === 'villas') {
      search['unitType'] = 'VILLA';
      title += 'Villas '
      description += 'Villas ';
    } else {
      title += 'Properties ';
      description += 'Properties ';
    }

    // Detect location
    const searchLocation = typeLocation.split('for-')[1].split('-').slice(1).join('-');
    console.log('searchLocation', searchLocation);
    if (searchLocation.length) {
      search['locations'] = searchLocation;
    } else if (location) {
      // Otherwise go for the emirate if it exists
      search['locations'] = location;
    }

    if (section === 'rent') {
      title += 'for Rent in ';
      description += 'for Rent in ';
    } else if (section === 'buy') {
      title += 'for Sale in ';
      description += 'for Sale in ';
    }

    // TODO: Add other unit types;
    // const location = parts.slice(3).join('-');
    if (searchLocation.length) {
      title += searchLocation.split('-').join(' ');
      title = title.replace(/\b([a-z])/g, (a) => a.toUpperCase());
      description += searchLocation.split('-').join(' ');
      description = description.replace(/\b([a-z])/g, (a) => a.toUpperCase());
    } else if (location) {
      title += location;
      description += location;
    } else {
      title += 'UAE';
      description += 'UAE';
    }

    title += ' | houhaa';
    description += ' | Explore Villas, Apartments, Land, Townhouses, Commercial Spaces and Off-plan projects for ';
    if (section === 'rent') {
      description += 'rent';
    } else if (section === 'buy') {
      description += 'sale';
    }
    this.title.setTitle(title);
    this.meta.updateTag({
      name: 'description', content: description
    }, `name='description'`);
    this.meta.updateTag({
        name: 'robots', content: 'index,follow'},
      `name='robots'`);
    this.linkService.removeTag('rel=canonical');
    this.linkService.addTag({
      rel: 'canonical', href: 'https://houhaa.com' + this.router.url
    });
    this.linkService.removeTag('rel=alternate');
    this.linkService.addTag({
      rel: 'alternate', hreflang: 'en', href: 'https://houhaa.com' + this.router.url
    });

    if (location) {
      if (!$.isEmptyObject(this.queryState)) {
        this.queryState = JSON.parse(this.queryState);
      }
    }

    // Sort properties
    search['sort'] = this.searchStateService.sortBy;

    this.queryState.locations = search['locations'];
    this.queryState.unitType = search['unitType'];
    this.queryState.listingType = search['listingType'];
    this.queryState.bedrooms = search['bedrooms'];
    this.queryState = JSON.stringify(this.queryState);
    this.locationValue = search['locations'];

    this.searchStateService.setSearchParams(search);
    this.searchStateService.searchProperties();
  }

  loadMore() {
    this.searchStateService.loadMore();
  }

  getSlidePhotos(property) {
    if (property && property.photos) return 'url(' + property.photos[0].originalUrl + ')';
  }

  setLocationToResultLocationArray(e) {
    this.locationValue = e;
  }

  resultLocationSlug(e) {
    this.resultSlug = e;
  }

  updateSortingQuery(e) {
    this.searchStateService.setSortedValue(e.value);
    this.buildSearch();
  }

  setSearchPropertyData(query) {
    this.router.navigateByUrl('en/search?' + query);
  }

}
