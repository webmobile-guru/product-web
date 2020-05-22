import { Component, Inject, OnInit, PLATFORM_ID, ViewEncapsulation } from '@angular/core';
import { Router } from '@angular/router';
import { SearchFormService } from '../search-form.service';
import * as $ from '../../../assets/js/vendor/jquery-3.4.1.js';
import { Subject } from 'rxjs';
import { debounceTime } from 'rxjs/operators';
import {
  searchFormHome,
  amenities,
  furnished,
  pricesRent,
  pricesSale,
  rooms,
  sizes,
  unitTypes,
  unitTypesCommercial,
  commercialType,
  sortingOptions
} from '../globals';
import { isPlatformServer } from '@angular/common';
import { SearchStateService } from '../property-search/search-state.service';

@Component({
  selector: 'app-property-search-form',
  templateUrl: './property-search-form.component.html',
  styleUrls: ['./property-search-form.component.scss'],
  encapsulation: ViewEncapsulation.None
})
export class PropertySearchFormComponent implements OnInit {
  propertyList: any = [];
  locationsArray: any = [];
  resultLocation: any = [];
  resultLocationSlug: any = [];
  bedroom: any = [];
  locationSearchValue = '';
  tabIndex = '';
  searchHistory = '';
  searchForm = searchFormHome; // search form global varible
  // define search form fields value;
  commercialType = commercialType;
  amenities = amenities;
  furnished = furnished;
  pricesRent = pricesRent;
  pricesSale = pricesSale;
  rooms = rooms;
  sizes = sizes;
  unitTypes = unitTypes;
  unitTypesCommercial = unitTypesCommercial;
  locationKeyup: Subject<string> = new Subject<string>();

  constructor(
    private router: Router,
    private searchFormService: SearchFormService,
    private searchStateService: SearchStateService,
    @Inject(PLATFORM_ID) private platformId
  ) {
    this.locationKeyup.pipe(debounceTime(500)).subscribe((model) => {
      this.searchResult();
    });
  }

  ngOnInit() {
    this.searchForm.commercialListingType = 'RENT';
    setTimeout(() => {
      this.setHomeScript();
    }, 200);
    this.tabChange(0);

    // Set Sort "FEATURED" By default
    this.searchStateService.sortBy = sortingOptions[0].value;
  }

  // search properties
  searchProperties(e) {
    e.preventDefault();
    this.searchForm.locations = '';
    if (this.resultLocationSlug.length) {
      this.resultLocationSlug.forEach((location) => {
        this.searchForm.locations += location + ',';
      });
      this.searchForm.locations = this.searchForm.locations.substr(0, this.searchForm.locations.length - 1);
      this.searchForm.locations = this.searchForm.locations.replace(/ /g, '-');
    }

    if (this.bedroom.length) {
      this.bedroom.forEach((element) => {
        this.searchForm.bedrooms += element + ',';
      });
      this.searchForm.bedrooms = this.searchForm.bedrooms.substr(0, this.searchForm.bedrooms.length - 1);
    }

    let searchFormData = { ...this.searchForm };
    let loc = this.searchForm.locations;
    this.searchForm.locations = '';
    searchFormData.locations = '';
    searchFormData.locations = loc;
    this.bedroom = [];
    let amenitiesOption = '';

    let amenitiesSelectedValue = $('input[name="hiddenAmeniti"]').val();
    if (amenitiesSelectedValue !== '' && amenitiesSelectedValue) {
      let parsedValue = JSON.parse(amenitiesSelectedValue);
      let amenities = parsedValue.filter((elem, index, self) => {
        return index === self.indexOf(elem);
      });
      amenitiesOption = amenities !== '' ? '&amenities=' + amenities : '';
    }
    let searchQuery = '';

    let setListingType = '';
    if (searchFormData.listingType === 'COMMERCIAL' && searchFormData.propertyCommercialType === 'COMMERCIAL_RENT') {
      setListingType = 'COMMERCIAL_RENT';
    } else if (
      searchFormData.listingType === 'COMMERCIAL' &&
      searchFormData.propertyCommercialType === 'COMMERCIAL_SALE'
    ) {
      setListingType = 'COMMERCIAL_SALE';
    } else {
      setListingType = searchFormData.listingType;
    }

    searchQuery +=
      (searchFormData.listingType !== '' ? '&listingType=' + setListingType : '') +
      (searchFormData.furnish !== '' ? '&furnished=' + searchFormData.furnish : '') +
      amenitiesOption;

    for (let [key, value] of Object.entries(searchFormData)) {
      if (
        value &&
        value !== '' &&
        value !== 0 &&
        key !== 'listingType' &&
        key !== 'commercialListingType' &&
        key !== 'propertyCommercialType' &&
        key !== 'furnish' &&
        key !== 'rooms'
      ) {
        searchQuery += ('&' + key + '=' + value).toString();
      }
    }

    // remove first &
    searchQuery = searchQuery.replace(/&/, '');

    if (this.resultLocation.length) localStorage.setItem('locationNameQuery', this.resultLocation.toString());
    this.router.navigateByUrl('en/search?' + searchQuery);
  }

  // search location Api calling
  searchLocation(event) {
    event.preventDefault();
    this.locationKeyup.next();
  }

  searchResult() {
    if (this.locationSearchValue && this.locationSearchValue !== this.searchHistory) this.locationsArray = [];
    if (this.locationSearchValue.length >= 3 && this.locationSearchValue !== this.searchHistory) {
      this.searchFormService.getLocation(this.locationSearchValue).subscribe(
        (res) => {
          this.locationsArray = res;
          this.searchHistory = this.locationSearchValue;
        },
        (err) => {
          console.error(err);
        }
      );
    }
  }

  onKeydownEnter(event) {
    event.preventDefault();
  }

  // add location slug
  addOption(name, slug) {
    if (this.resultLocationSlug.indexOf(slug) === -1) {
      this.resultLocation.push(name);
      this.resultLocationSlug.push(slug);
      this.locationsArray = [];
      this.locationSearchValue = '';
    }
  }

  // remove location slug
  removeOption(index) {
    this.resultLocation.splice(index, 1);
    this.resultLocationSlug.splice(index, 1);
  }

  updateBedrooms(event) {
    this.searchForm.bedrooms = '';
    this.bedroom = [];
    this.bedroom.push(event.target.value);
    this.bedroom.sort();
  }

  tabChange(value) {
    if (value === 1) {
      this.searchForm.listingType = 'RENT';
      this.searchForm.propertyCommercialType = '';
    } else if (value === 0) {
      this.searchForm.listingType = 'SALE';
      this.searchForm.propertyCommercialType = '';
    } else if (value === 2) {
      this.searchForm.listingType = 'COMMERCIAL';
      this.searchForm.propertyCommercialType = 'COMMERCIAL_RENT';
    }

    if (this.tabIndex !== value) {
      // this.searchForm.listingType = '';
      this.searchForm.unitType = '';
      this.searchForm.furnish = '';
      this.searchForm.agent = '';
      this.searchForm.locations = '';
      this.searchForm.minPrice = 0;
      this.searchForm.maxPrice = 0;
      this.searchForm.bedrooms = '';
      this.searchForm.minArea = 0;
      this.searchForm.maxArea = 0;
      this.searchForm.agency = '';
      this.searchForm.reference = '';
      this.locationSearchValue = '';
      this.resultLocation = [];
      this.locationsArray = [];
      this.bedroom = [];
      this.searchForm.rooms = 0;

      if (!isPlatformServer(this.platformId)) {
        // If not the server
        const elementRoom = document.getElementsByClassName('rooms-selector__input');
        for (let i = 0; i < elementRoom.length; i++) {
          elementRoom[i]['checked'] = false;
        }
      }
    }

    this.tabIndex = value;
  }

  getSlidePhotos(property) {
    if (property && property.photos) return 'url(' + property.photos[0].originalUrl + ')';
  }

  setHomeScript() {
    if (isPlatformServer(this.platformId)) {
      return;
    }
    const toggleTabs = function () {
      const currentTabElem = this;
      const tabIndex = currentTabElem.dataset.tab;
      const currentTabContentElem = document.querySelector(
        '.new-search-tabs-content__section[data-tab="' + tabIndex + '"]'
      );
      const activeTabElem = document.querySelector('.new-search-tabs__btn.js-active');
      const activeTabContentElem = document.querySelector('.new-search-tabs-content__section.js-active');

      activeTabElem.classList.remove('js-active');
      activeTabElem.removeAttribute('tabindex');

      activeTabContentElem.classList.remove('js-active');

      currentTabElem.classList.add('js-active');
      currentTabElem.setAttribute('tabindex', -1);

      currentTabContentElem.classList.add('js-active');
    };

    if (document.querySelector('.new-search')) {
      const buttonsList = document.querySelectorAll('.new-search-tabs__btn');

      Array.from(buttonsList, (item) => {
        item.addEventListener('click', toggleTabs);
      });
    }
  }

  ngAfterViewInit() {
    if (isPlatformServer(this.platformId)) {
      return;
    }
    let isFound = false;
    let scripts = document.getElementsByTagName('script');
    for (let i = 0; i < scripts.length; ++i) {
      if (scripts[i].getAttribute('src') !== null && scripts[i].getAttribute('src').includes('loader')) {
        isFound = true;
      }
    }
    if (!isFound) {
      let dynamicScripts = [
        'assets/js/vendor/multiple-select-1.2.3.js',
        'assets/js/components/multiple-select.js',
        'assets/js/components/custom.js'
      ];
      for (let i = 0; i < dynamicScripts.length; i++) {
        let node = document.createElement('script');
        node.src = dynamicScripts[i];
        node.type = 'text/javascript';
        node.async = false;
        node.charset = 'utf-8';
        document.getElementsByTagName('head')[0].appendChild(node);
      }
    }
  }

  commercialTypeChange(typeValue) {
    if (typeValue === 'COMMERCIAL_SALE') {
      this.searchForm.commercialListingType = 'SALE';
    } else if (typeValue === 'COMMERCIAL_RENT') {
      this.searchForm.commercialListingType = 'RENT';
    }
    this.searchForm.minPrice = 0;
    this.searchForm.maxPrice = 0;
  }
}
