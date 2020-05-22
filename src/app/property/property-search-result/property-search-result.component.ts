import {
  Component,
  Input,
  OnInit,
  Output,
  EventEmitter,
  SimpleChange,
  ɵConsole,
  Inject,
  PLATFORM_ID
} from '@angular/core';
import { Property } from '../model/property';
import { SearchStateService } from '../property-search/search-state.service';
import { Router, ActivatedRoute } from '@angular/router';
import { AgentService } from '../../agent/agent.service';
import { environment } from '../../../environments/environment';
import { isPlatformServer } from '@angular/common';
import { sortingOptions } from '../globals';
import { HttpParams } from '@angular/common/http';
import { Meta, Title } from '@angular/platform-browser';
import { LinkService } from '../../components/links/LinkService';

@Component({
  selector: 'app-property-search-result',
  templateUrl: './property-search-result.component.html',
  styleUrls: ['./property-search-result.component.css'],
  providers: [LinkService]
})
export class PropertySearchResultComponent implements OnInit {
  @Output() setLocationToSearch = new EventEmitter<any>();
  @Output() resultLocationSlugEmit = new EventEmitter<any>();
  @Output() updateSortingQueryData = new EventEmitter<any>();

  @Input() property: Property;
  @Input() properties;

  queryResultLocation: object;

  // listing search previous value
  clickListingSearchHistory = '';

  agentId: string;
  locations: any = [];
  agentName: string = '';
  setParams: any;
  clickedLocations: any;
  clickedSlugs: any;
  setBedroom: any;
  parentTree: any;
  checkBreadcrumbs: boolean;
  offset: any = 8;
  queryParams: any;

  queryState: any = {};
  unitTypeSearch: any;
  commercialListingType: any;
  sortOptions: any = sortingOptions;

  constructor(
    public searchStateService: SearchStateService,
    private router: Router,
    private route: ActivatedRoute,
    private agentService: AgentService,
    private title: Title,
    private meta: Meta,
    private linkService: LinkService,
    @Inject(PLATFORM_ID) private platformId
  ) { }

  ngDoCheck() {
    if (isPlatformServer(this.platformId)) {
      return;
    }
    this.parentTree = this.searchStateService.parents.value && this.searchStateService.parents.value;

    const locationParams = localStorage.getItem('locationNameQuery');
    if (locationParams) {
      const setLocationValues = locationParams.replace(new RegExp(',', 'g'), ', ');
      this.setParams = setLocationValues;

      if (this.setParams && this.setParams.split(',').length > 1) {  // show if multiple location filter apply (checkBreadcrumbs check added)
        this.checkBreadcrumbs = true;
      } else {
        this.checkBreadcrumbs = false;
      }
    }
    const currentUrl = this.router.url;
    const listingtype = currentUrl.split('?listingType='); // check added for listingType
    if (listingtype[1]) {
      const listingSelected = listingtype[1].toString().substr(0, listingtype[1].indexOf('&'));
      if (listingSelected && listingSelected !== '') {
        this.commercialListingType = listingSelected;
      } else {
        this.commercialListingType = listingtype[1];
      }
    }

    const newUrl = currentUrl.split('&bedrooms='); // check added for bedroom
    if (newUrl[1]) {
      const setUrl = newUrl[1].toString().substr(0, newUrl[1].indexOf('&'));
      if (setUrl && setUrl !== '') {
        this.setBedroom = setUrl + ' bed';
      } else {
        this.setBedroom = newUrl[1] + ' bed';
      }
    }

    let unitTypeValue = currentUrl.split('&'); //check unitType
    unitTypeValue = unitTypeValue.toString().split('unitType='); //check unitType
    if (Number(unitTypeValue.length) > 1) {
      unitTypeValue = unitTypeValue.toString().split(',');
      if (unitTypeValue[2]) {
        this.unitTypeSearch = unitTypeValue[2];
      }
    }
  }

  ngOnInit() {
    // get Search query if search by agent
    this.route.params.subscribe((val) => {
      this.agentId = val.id;
      if (this.agentId) {
        this.agentService.getAgent(this.agentId).subscribe(
          (agentDetail) => {
            this.agentName = agentDetail.name;
          },
          (err) => {
            console.log(err);
          }
        );
      }
    });
    this.route.queryParams.subscribe(params => {
      this.queryParams = {...params};
    });
    setTimeout(() => {
      this.setPropertyListVerifiedScript();
    }, 500);
  }

  // load more properties
  loadMore() {
    this.searchStateService.loadMore();
    this.updateVerifiedScript();
  }

  ngOnChanges(changes: SimpleChange) {
    this.updateVerifiedScript();
  }

  getAltName(property) {
    if (property && property.agency && property.agency.name) {
      return property.agency.name;
    } else {
      return '';
    }
  }

  // load more properties if search by agent
  loadMoreAgentProperties() {
    // TODO : Change for search by agent with pagination
    this.properties = [];
  }

  // get Agent Image on property if search by agent and if not then static for now
  getAgentImage(property) {
    if (property.agent && property.agent.photo) {
      return 'url(' + environment.S3_URL + property.agent.photo.url + ')';
    }
  }

  // Property Image
  getSlidePhotos(property) {
    if (property && property.photos && property.photos[0] && property.photos[0].thumb) {
      return 'url(' + environment.S3_URL + property.photos[0].thumb + ')';
    } else {
      return 'url(' + 'assets/pic/property-default' + ')';
    }
  }

  // get header logo
  getPropertyHeader(property) {
    if (property && property.agency && property.agency.logo && property.agency.logo.small)
      return environment.S3_URL + property.agency.logo.small;
  }

  getBackgroundColor(property) {
    if (property && property.agency && property.agency.bgColor) {
      return property.agency.bgColor;
    }
  }

  // format property price
  formatNumber(value) {
    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  }

  locationSearchsTop(slug, name) {
    const checkQuickSearch = 'checkQuickSearch';
    this.resultLocationSlugEmit.emit({ slug, name, checkQuickSearch });
  }

  changeLocationUrl(slug, name) {
    // if the url starts with /en/ then we can assume for now
    // were on a clean url
    const currentUrl = this.router.url;
    if (currentUrl.substr(0, 10) === '/en/search') {
      // console.log(this.route.queryParams);
      // Handle old style search as before
      const qp: HttpParams = {
        ...this.queryParams,
        locations: slug
      };
      return ['/en/search', qp];
    } else {
      // Do we already have a location in the URL?
      const currentLoction = currentUrl.split('for-')[1].split('-').slice(1).join('-');
      if (currentLoction.length) {
        // Replace current location with new location in url
        // console.log
        return [currentUrl.substring(0, currentUrl.length - currentLoction.length) + slug, {}];
      } else {
        return [currentUrl + '-' + slug, {}];
      }
    }

  }

  locationSearch(slug, name, e, type, clickedLocation, clickedLocationslug) {
    if (isPlatformServer(this.platformId)) {
      return;
    }
    e.preventDefault();
    const locarr = [];
    const clickedLocationslugs = [];

    if (clickedLocation) {
      locarr.push(clickedLocation.loc1, clickedLocation.loc2, clickedLocation.loc3, clickedLocation.loc4);
      this.clickedLocations = locarr.filter((val) => {
        return val !== '' && val !== undefined;
      });
    }

    if (clickedLocationslug) {
      clickedLocationslugs.push(
        clickedLocationslug.slug1,
        clickedLocationslug.slug2,
        clickedLocationslug.slug3,
        clickedLocationslug.slug4
      );
      this.clickedSlugs = clickedLocationslugs.filter((val) => {
        return val !== '' && val !== undefined;
      });
    }

    if (localStorage.getItem('locationItemSearchHistory') !== slug) {
      localStorage.setItem('locationNameQuery', name);
      // empty property array for loader if listing click value is changed
      this.properties = [];
      this.clickListingSearchHistory = slug;
      localStorage.setItem('locationItemSearchHistory', slug);
      this.setLocationToSearch.emit(slug);
    }
    const checkQuickSearch = 'checkQuickSearch';
    this.resultLocationSlugEmit.emit({ slug, name, checkQuickSearch });
  }

  changeUnitType(commercialUnitType) {
    return commercialUnitType.replace(/_/g, ' ').toLowerCase();
  }

  searchParamsWithLocation(location: string): object {
    const newParams = { ...this.queryResultLocation };
    newParams['locations'] = location;
    return newParams;
  }

  // toggle verified flag
  toggleExplanation = function () {
    const verifiedElem = this;
    if (!verifiedElem.classList.contains('js-expanded')) {
      verifiedElem.classList.add('js-expanded');
    } else {
      verifiedElem.classList.remove('js-expanded');
    }
  };

  setPropertyListVerifiedScript() {
    if (isPlatformServer(this.platformId)) {
      return;
    }
    const verifiedItemsList = document.querySelectorAll('.verified');
    Array.from(verifiedItemsList, (item) => {
      item.addEventListener('click', this.toggleExplanation);
    });
  }

  updateVerifiedScript() {
    if (isPlatformServer(this.platformId)) {
      return;
    }
    // remove verified flag script for previous properties
    const verifiedItemsListRemove = document.querySelectorAll('.verified');
    Array.from(verifiedItemsListRemove, (item) => {
      item.removeEventListener('click', this.toggleExplanation);
    });

    // load Verified flag script again for all updated properties
    setTimeout(() => {
      this.setPropertyListVerifiedScript();
    }, 500);
  }

  toggleShowHide() {
    if (this.offset <= 8) {
      this.offset = this.searchStateService.locationsProp.value;
      this.offset = this.offset.length;
    } else {
      this.offset = 8;
    }
  }

  bindListingtype(type, unitType, bedRoomsValue) {
    const currentUrl = this.router.url.split('&').length;
    if (currentUrl && currentUrl === 1) {
      unitType = '';
      bedRoomsValue = '';
    }

    let setPropertyTypeValue = '';

    if (unitType && !bedRoomsValue) {
      let typecheck = type.charAt(0).toUpperCase() + type.substr(1).toLowerCase();
      if (typecheck === 'Commercial_rent') {
        typecheck = 'Rent';
      }
      setPropertyTypeValue =
        ' ' + unitType.charAt(0).toUpperCase() + unitType.substr(1).toLowerCase() + ' for ' + typecheck;
      return setPropertyTypeValue;
    }

    if (!unitType && !bedRoomsValue) {
      switch (type) {
        case 'RENT':
          setPropertyTypeValue = ' Properties for Rent';
          break;
        case 'SALE':
          setPropertyTypeValue = ' Properties for Sale';
          break;
        case 'COMMERCIAL_RENT':
          setPropertyTypeValue = ' Commercial Properties for Rent';
          break;
        case 'COMMERCIAL_SALE':
          setPropertyTypeValue = ' Commercial Properties for Sale';
          break;
      }
      return setPropertyTypeValue;
    }

    if (bedRoomsValue) {
      let setType = '';
      let selectedBedrooms = '';
      const bedRoomOptions = bedRoomsValue.split(',');
      const res = bedRoomOptions[bedRoomOptions.length - 1];

      if (res.split(' ')[1] === 'bed') {
        selectedBedrooms = 'Bedroom';
      }
      if (unitType) {
        setType =
          ' ' +
          unitType.charAt(0).toUpperCase() +
          unitType.substr(1).toLowerCase() +
          ' for ' +
          type.charAt(0).toUpperCase() +
          type.substr(1).toLowerCase();
      }
      setPropertyTypeValue = ' ' + res.split(' ')[0] + ' ' + selectedBedrooms + setType;
      return setPropertyTypeValue;
    }
  }

  updateSortedData() {
    const selectedOption = this.sortOptions.filter(item => item.value === this.searchStateService.sortBy);
    this.updateSortingQueryData.emit(selectedOption[0]);
  }

}
