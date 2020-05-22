import {
  Component,
  OnInit,
  Output,
  EventEmitter,
  Input,
  SimpleChanges,
  ViewEncapsulation,
  Inject,
  PLATFORM_ID
} from '@angular/core';
import { SearchFormService } from '../search-form.service';

import * as $ from '../../../assets/js/vendor/jquery-3.4.1.js';
import {
  minBed,
  maxBed,
  rentalLength,
  completionStatus,
  commercialType,
  amenities,
  furnished,
  pricesRent,
  pricesSale,
  sizes,
  unitTypes,
  unitTypesCommercial,
  searchFormHeader
} from '../globals';
import { Subject } from 'rxjs';
import { debounceTime } from 'rxjs/operators';
import { isPlatformServer } from '@angular/common';
import { ActivatedRoute } from '@angular/router';
import { SearchStateService } from '../property-search/search-state.service';
@Component({
  selector: 'app-custom-search-header',
  templateUrl: './custom-search-header.component.html',
  styleUrls: ['./custom-search-header.component.scss'],
  encapsulation: ViewEncapsulation.None
})
export class CustomSearchHeaderComponent implements OnInit {
  @Output() searchEvent = new EventEmitter<any>();
  @Input() queryData: any;
  @Input() locationValue: string;
  @Input() resultSlug: any;

  checkMobile = false;
  propertyList: any = [];
  locationsArray: any = [];
  resultLocation: any = [];
  resultLocationSlug: any = [];
  bedrooms: any = [];
  locationSearchValue = '';
  tabIndex = '';
  searchHistory = '';
  timer = 0;
  loadScript = true;
  searchForm = searchFormHeader; // search form global variable
  // define search form fields value;
  commercialType = commercialType;
  amenities = amenities;
  furnished = furnished;
  pricesRent = pricesRent;
  pricesSale = pricesSale;
  sizes = sizes;
  unitTypes = unitTypes;
  unitTypesCommercial = unitTypesCommercial;
  rentalLength = rentalLength;
  completionStatus = completionStatus;
  minBed = minBed;
  maxBed = maxBed;
  locationKeyup: Subject<string> = new Subject<string>();

  constructor(public searchStateService: SearchStateService, private searchFromService: SearchFormService, @Inject(PLATFORM_ID) private platformId, private route: ActivatedRoute) {
    this.locationKeyup.pipe(debounceTime(500)).subscribe((model) => {
      this.searchResult();
    });

    if (isPlatformServer(this.platformId)) {
      return;
    }

    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      this.checkMobile = true;
    }
  }

  ngOnInit() {

    if (isPlatformServer(this.platformId)) {
      return;
    }

    this.route.queryParams.subscribe(params => {
      if (params['sort']) this.searchStateService.sortBy = params['sort'];
    });

    this.searchForm.commercialListingType = 'RENT';

    if ((this.queryData !== '' && this.queryData !== undefined) || (this.queryData && this.queryData.locations !== undefined)) {
      this.queryData = JSON.parse(this.queryData);
      this.searchForm.propertyCommercialType = this.queryData.listingType;

      if ((this.queryData.listingType !== undefined) || (this.queryData && this.queryData.locations !== undefined)) {
        if (this.queryData.listingType !== undefined) {
          this.searchForm.listingType = this.queryData.listingType;
        }
      }

      for (const [key, value] of Object.entries((this.queryData))) {
        if (key !== 'locations' && key !== 'amenities' && key !== 'bedrooms') {
          this.searchForm[key] = value;
        }
      }
      if (this.queryData.amenities) {
        this.searchForm.amenities = this.queryData.amenities.split(',');
      }
      if (this.queryData.locations) {
        if (this.locationValue === '' || this.locationValue === undefined) {
          this.resultLocationSlug = this.queryData.locations.split(',');
        } else {
          this.resultLocationSlug = [];
          this.resultLocation = [];
          this.resultLocationSlug.push(this.queryData.locations);
        }
      }
      if (this.queryData.bedrooms) {
        this.bedrooms = this.queryData.bedrooms.split(',');
      }
    }
    setTimeout(() => {
      this.setSearchScript();
    }, 50);
    setTimeout(() => {
      this.fetchQueryParams();
    }, 1000);

  }

  ngDoCheck(changes: SimpleChanges) {
    if (isPlatformServer(this.platformId)) {
      return;
    }
    this.setLocations();
    if (this.locationValue !== '' && this.locationValue !== undefined) {
      if (
        this.resultLocationSlug.indexOf(this.locationValue) === -1 ||
        (this.resultLocationSlug.length > 1 || this.resultLocation.length > 1)
      ) {
        this.resultLocationSlug = [];
        this.resultLocation = [];
        this.resultLocationSlug = this.locationValue.split(',');
      }
    }
  }

  ngOnChanges(changes: SimpleChanges) {
    if (changes.queryData && changes.queryData.currentValue) {
      const res = JSON.parse(changes.queryData && changes.queryData.currentValue);
      if (!res['locations']) {
        this.resultLocationSlug = [];
        this.resultLocation = [];
        if ($('button.main-search-dropdown__close-btn').is(':visible')) {
          $('button.main-search-dropdown__close-btn').trigger('click');
        }
      }
    }

    if (isPlatformServer(this.platformId)) {
      return;
    }
    const pathName = window.location.href.split('?'); // Returns path only (/path/example.html)
    if (this.searchFromService.searchCheck && this.searchFromService.searchName && this.searchFromService.searchName !== '') {
      const newUrl = pathName[0].split('/');
      if ($.inArray("sale", newUrl) !== -1) {
        setTimeout(() => {
          $('.SALE-1').trigger('click');
        }, 1000);
      }

      if ($.inArray("rent", newUrl) !== -1) {
        setTimeout(() => {
          $('.RENT-1').trigger('click');
        }, 1000);
      }
      this.resultLocationSlug = [];
      this.resultLocation = [];
      this.resultLocationSlug.push(this.searchFromService.searchSlug);
      this.resultLocation.push(this.searchFromService.searchName);
      this.searchFromService.searchCheck = false;
      if ($('.main-search-dropdown__close-btn').is(":visible")) {
        $('.main-search-dropdown__close-btn').trigger('click');
      }
    }

    const _this = this;
    setTimeout(() => {
      if (changes.queryData && changes.queryData.currentValue) {
        const urlQuery = JSON.parse(changes.queryData.currentValue)
        _this.searchForm.minBed = 0;
        for (const [key, value] of Object.entries(urlQuery)) {
          if (key != 'bedrooms') {
            _this.searchForm[key] = value;
          }
          if (key === 'bedrooms') {
            let d: any = value;
            _this.searchForm.minBed = d;
          }
        }
      }
    }, 1400);

    if (changes.queryData && changes.queryData.previousValue !== undefined && changes.queryData.previousValue !== "") {
      changes.queryData.previousValue = changes.queryData.previousValue && JSON.parse(changes.queryData.previousValue);
    }
    let type = '';
    if (pathName[1]) {
      const newUrl = pathName[1].split('&');

      // if first quertParma is "listingType"
      if (newUrl[0].split('=')[0] === 'listingType') {
        type = newUrl[0].split('=')[1];
        this.searchForm.listingType = type;
      }

      if (type === 'RENT') {
        $('.RENT-1').trigger('click');
      }

      if (type === 'SALE') {
        $('.SALE-1').trigger('click');
      }

      if (changes.queryData && changes.queryData.previousValue && (changes.queryData.previousValue.listingType === 'RENT' || changes.queryData.previousValue.listingType === 'SALE') && (type === 'COMMERCIAL_RENT' || type === 'COMMERCIAL_SALE')) {
        this.loadSearchScript();
      }

      if (changes.queryData && changes.queryData.previousValue && (changes.queryData.previousValue.listingType === 'COMMERCIAL_RENT' || changes.queryData.previousValue.listingType === 'COMMERCIAL_SALE') && (type == 'RENT' || type === 'SALE')) {
        this.loadSearchScript();
      }
    }
    if (this.resultSlug && this.resultSlug && this.resultLocationSlug.indexOf(this.resultSlug.slug) === -1) {
      this.resultLocationSlug = [];
      this.resultLocation = [];
      this.resultLocationSlug.push(this.resultSlug.slug);
      this.resultLocation.push(this.resultSlug.name);

      // if click on nav click then don't trigger search button event
      if (!this.searchStateService.getNav()) {
        $('button.main-search-location__submit-btn').trigger('click');
      } else {
        this.route.queryParams.subscribe(params => {
          this.clearForm(params['listingType'])
          if (params['rentalLength']) {
            this.searchForm.rentalLength = params['rentalLength']
          }
        });
      }

      return false;
    } else if (!this.resultSlug && this.locationValue && this.locationValue != '') {
      this.resultLocationSlug = [];
      this.resultLocation = [];
      this.resultLocationSlug = this.locationValue.split(',');
      this.resultLocation = localStorage.getItem('locationNameQuery').split(',');
    }

    // Clear navClicked value if true
    this.searchStateService.getNav() && this.searchStateService.unsetNav();
  }

  setLocations() {
    const pathName = window.location.href.split('?'); // Returns path only (/path/example.html)  
    const setLocation = this.searchStateService.searchLocations.value && this.searchStateService.searchLocations.value;
    if ($(".listings.checkListings").is(":visible") && pathName.length <= 2) {

      const newUrl = pathName[0].split('/');
      if ($.inArray("sale", newUrl) !== -1) {
        $('.SALE-1').trigger('click');
      }

      if ($.inArray("rent", newUrl) !== -1) {
        $('.RENT-1').trigger('click');
      }

      if (setLocation) {
        this.resultLocationSlug = [];
        this.resultLocation = [];
        var setValues: any = [];
        for (const [key, value] of Object.entries(setLocation)) {
          this.resultLocationSlug.push(value.slug);
          this.resultLocation.push(value.name);
          setValues.push(value.name.toString());
        }
        setTimeout(() => {
          $(".listings.checkListings").removeClass('checkListings');
        }, 1500)
      }
    }
  }

  // search properties
  searchProperties(event) {
    if (isPlatformServer(this.platformId)) {
      return;
    }
    this.loadScript = false;
    event.preventDefault();
    this.searchForm.locations = '';
    if (this.resultLocationSlug.length) {
      this.resultLocationSlug.forEach((location) => {
        this.searchForm.locations += location + ',';
      });
      this.searchForm.locations = this.searchForm.locations.substr(0, this.searchForm.locations.length - 1);
    }

    if (this.bedrooms.length) {
      this.searchForm.bedrooms = '';
      this.bedrooms.forEach((element) => {
        this.searchForm.bedrooms += element + ',';
      });
      this.searchForm.bedrooms = this.searchForm.bedrooms.substr(0, this.searchForm.bedrooms.length - 1);
    }

    const searchFormData = { ...this.searchForm };

    const loc = this.searchForm.locations;
    this.searchForm.locations = '';
    searchFormData.locations = '';
    searchFormData.locations = loc;

    // check for amenities && get amenities values
    let amenitiesOption = '';
    const amenitiesSelectedValue = $('input[name="hiddenAmeniti"]').val();

    if (amenitiesSelectedValue !== '' && amenitiesSelectedValue !== undefined) {
      const parsedValue = JSON.parse(amenitiesSelectedValue);
      const selectedAmenities = parsedValue.filter(function (elem, index, self) {
        return index === self.indexOf(elem);
      });
      amenitiesOption = selectedAmenities !== '' ? '&amenities=' + selectedAmenities : '';
    }

    if (this.checkMobile) {
      if (searchFormData.amenities[0] === 'All') {
        const dataAmenities = [];
        amenitiesOption = '';
        this.amenities.forEach(element => {
          dataAmenities.push(element.value);
        });
        amenitiesOption = ('&amenities=' + dataAmenities);
        searchFormData.amenities = '';
      }
    }

    let setListingType = '';
    let searchQuery = '';

    // searchFormData.listingType ='COMMERCIAL';
    if (
      (searchFormData.listingType === 'COMMERCIAL' || searchFormData.listingType === 'COMMERCIAL_RENT') &&
      searchFormData.propertyCommercialType === 'COMMERCIAL_RENT'
    ) {
      setListingType = 'COMMERCIAL_RENT';
    } else if (
      (searchFormData.listingType === 'COMMERCIAL' || searchFormData.listingType === 'COMMERCIAL_SALE') &&
      searchFormData.propertyCommercialType === 'COMMERCIAL_SALE'
    ) {
      setListingType = 'COMMERCIAL_SALE';
    } else {
      setListingType = searchFormData.listingType;
    }

    searchQuery +=
      (searchFormData.listingType !== '' ? '&listingType=' + setListingType : '') +
      (searchFormData.furnishing !== '' ? '&furnished=' + searchFormData.furnishing : '') +
      amenitiesOption;

    for (const [key, value] of Object.entries(searchFormData)) {
      if (
        value &&
        value !== '' &&
        value !== "0" &&
        key !== 'listingType' &&
        key !== 'commercialListingType' &&
        key !== 'propertyCommercialType' &&
        key !== 'furnishing' &&
        key !== 'furnished' &&
        key !== 'rooms' &&
        key !== 'amenities'
      ) {
        searchQuery += ('&' + key + '=' + value).toString();
      }
    }

    searchQuery = searchQuery.replace(/&/, '');
    this.searchEvent.emit(searchQuery);
    this.locationValue = '';
  }

  searchLocation(e) {
    e.preventDefault();
    this.locationKeyup.next();
  }

  searchResult() {
    if (this.locationSearchValue && this.locationSearchValue !== this.searchHistory) {
      this.locationsArray = [];
    }
    if (this.locationSearchValue.length >= 3 && this.locationSearchValue !== this.searchHistory) {
      this.searchFromService.getLocation(this.locationSearchValue).subscribe(
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

  clearForm(type) {
    this.locationValue = '';
    this.searchForm.unitType = '';
    this.searchForm.agent = '';
    this.searchForm.locations = '';
    this.searchForm.minPrice = 0;
    this.searchForm.maxPrice = 0;
    this.searchForm.bedrooms = '';
    this.searchForm.minArea = 0;
    this.searchForm.maxArea = 0;
    this.searchForm.agency = '';
    this.searchForm.reference = '';
    this.searchForm.furnishing = '';
    this.searchForm.propertyCommercialType = '';
    this.bedrooms = [];
    this.locationSearchValue = '';
    this.resultLocationSlug = [];
    this.resultLocation = [];
    this.searchHistory = '';
    this.searchForm.amenities = '';
    $('.ms-drop.bottom ul li input').each(function (k, v) {
      if ($(this).is(':checked')) {
        $(this).trigger('click');
      }
    });
    $('input[name="hiddenAmeniti"]').val('');
    this.searchForm.listingType = type;
    this.searchForm.completionStatus = 0;
    this.searchForm.rentalLength = 0;
    this.searchForm.maxBed = 0;
    this.searchForm.minBed = 0;
  }

  // add location slug
  addOption(slug, name) {
    this.locationValue = '';
    if (this.resultLocationSlug.indexOf(slug) === -1) {
      this.resultLocationSlug.push(slug);
      this.resultLocation.push(name);
      this.locationsArray = [];
      this.locationSearchValue = '';
    }
  }

  // remove location slug
  removeOption(index) {
    this.locationValue = '';
    this.resultLocationSlug.splice(index, 1);
    this.resultLocation.splice(index, 1);
    this.resultSlug = [];
  }

  tabChange(value) {
    if (value === 0) {
      this.searchForm.listingType = 'RENT';
      this.searchForm.propertyCommercialType = '';
    } else if (value === 1) {
      this.searchForm.listingType = 'SALE';
      this.searchForm.propertyCommercialType = '';
    } else if (value === 2) {
      this.searchForm.listingType = 'COMMERCIAL_RENT';
      this.searchForm.propertyCommercialType = 'COMMERCIAL_RENT';
    } else if (value === 3) {
      this.searchForm.listingType = 'COMMERCIAL_SALE';
    }

    if (this.tabIndex !== value) {
      this.searchForm.unitType = '';
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
      this.locationsArray = [];
      this.bedrooms = [];
      this.searchForm.furnishing = '';
      $('.ms-drop.bottom ul li input').each(function (k, v) {
        if ($(this).is(':checked')) {
          $(this).trigger('click');
        }
      });
      $('input[name="hiddenAmeniti"]').val('');
      this.searchForm.maxBed = 0;
      this.searchForm.minBed = 0;
      this.searchForm.rentalLength = 0;
      this.searchForm.completionStatus = 0;
      const element = document.getElementsByClassName('rooms-selector__input');
      for (let i = 0; i < element.length; i++) {
        element[i]['checked'] = false;
      }
    }
    this.tabIndex = value;
  }

  fetchQueryParams() {
    this.route.queryParams.subscribe((val) => {
      for (const [key, value] of Object.entries(val)) {
        if (key === 'furnished') {
          const f = 'furnishing';
          this.searchForm[f] = value;
        } else if (key === 'bedrooms') {
          const m = 'minBed';
          this.searchForm[m] = value;
        } else {
          this.searchForm[key] = value;
        }
      }
    })
  }

  checkBedrooms(bed) {
    if (this.bedrooms.indexOf(bed) !== -1) {
      return true;
    }
  }

  removeScripts() {
    return $('html').find('script').filter(function () {
      return [
        $(this).attr('src') === 'assets/js/components/main-search.js',
        $(this).attr('src') === 'assets/js/vendor/multiple-select-1.2.3.js',
        $(this).attr('src') === 'assets/js/components/multiple-select.js',
        $(this).attr('src') === 'assets/js/components/custom.js'
      ]
    }).remove();
  }

  setSearchScript() {
    setTimeout(() => {
      this.removeScripts()
      let isFound = false;
      const scripts = document.getElementsByTagName('script');
      for (let i = 0; i < scripts.length; ++i) {
        if (scripts[i].getAttribute('src') !== null && scripts[i].getAttribute('src').includes('loader')) {
          isFound = true;
        }
      }

      if (!isFound && this.loadScript) {
        const dynamicScripts = [
          'assets/js/components/main-search.js',
          'assets/js/vendor/multiple-select-1.2.3.js',
          'assets/js/components/multiple-select.js',
          'assets/js/components/custom.js',
        ];
        for (let i = 0; i < dynamicScripts.length; i++) {
          const node = document.createElement('script');
          node.src = dynamicScripts[i];
          node.type = 'text/javascript';
          node.async = false;
          node.charset = 'utf-8';
          document.getElementsByTagName('head')[0].appendChild(node);
        }
      }
    }, 500);
  }

  loadSearchScript() {
    if (isPlatformServer(this.platformId)) {
      return;
    }

    setTimeout(() => {
      this.removeScripts()

      let isFound = false;
      const scripts = document.getElementsByTagName('script');
      for (let i = 0; i < scripts.length; ++i) {
        if (scripts[i].getAttribute('src') !== null && scripts[i].getAttribute('src').includes('loader')) {
          isFound = true;
        }
      }
      if (!isFound) {
        const dynamicScripts = [
          'assets/js/components/main-search.js',
          'assets/js/vendor/multiple-select-1.2.3.js',
          'assets/js/components/multiple-select.js',
          'assets/js/components/custom.js'
        ];
        for (let i = 0; i < dynamicScripts.length; i++) {
          const node = document.createElement('script');
          node.src = dynamicScripts[i];
          node.type = 'text/javascript';
          node.async = false;
          node.charset = 'utf-8';
          document.getElementsByTagName('head')[0].appendChild(node);
        }
      }
    }, 1500)
  }
}
