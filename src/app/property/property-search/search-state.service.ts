import { Injectable } from '@angular/core';
import { Observable, Subject, BehaviorSubject } from 'rxjs';
import { Property } from '../model/property';
import { PropertyService } from '../property.service';
import { Params, Router } from '@angular/router';
import { Location } from '../../location/location/location';
import { sortingOptions } from '../globals';

@Injectable({
  providedIn: 'root'
})
export class SearchStateService {
  public searchingProperty = new BehaviorSubject(false);
  public isLoading = new BehaviorSubject(false);

  page = 1;
  private properties$ = new Subject<Property[]>();
  private properties: Property[] = [];
  private searchParams: Params;
  private location$ = new Subject<Location>();
  private location: Location;
  locations: any = [];
  listCount = new BehaviorSubject(false);
  locationsProp = new BehaviorSubject(false);
  parents = new BehaviorSubject(false);
  searchLocations = new BehaviorSubject(false);
  sortBy = sortingOptions[0].value;
  isNavClicked = false;

  constructor(
    private propertyService: PropertyService,
    private router: Router) { }

  getNav() {
    return this.isNavClicked;
  }

  setNav() {
    this.isNavClicked = true;
  }

  unsetNav() {
    this.isNavClicked = false;
  }

  setSortedValue(s = sortingOptions[0].value) {
    this.sortBy = s;
    const href = window.location.href
    const urlParts = href.split('?');
    let sortedQuery = '';

    // if QueryParms and first QueryParms is not sort
    if (urlParts.length > 1 && href.indexOf('?sort=') === -1) {
      let query = urlParts[1];

      if (query.indexOf('sort=') !== -1) {
        let queryFirst = query.substr(0, query.indexOf('sort='));
        let queryLast = query.substr(query.indexOf('sort='), query.length);
        if (queryLast.indexOf('&') === -1) {
          sortedQuery = 'en/search?' + queryFirst + 'sort=' + this.sortBy;
        } else {
          let querySecond = queryLast.substr(queryLast.indexOf('&'), queryLast.length);
          sortedQuery = 'en/search?' + queryFirst + '&' + querySecond + 'sort=' + this.sortBy;
        }
      } else {
        sortedQuery = 'en/search?' + urlParts[1] + '&sort=' + this.sortBy;
      }
      this.router.navigateByUrl(sortedQuery);

    } else {
      // if url = /:type/:city/:area
      // If short links
      const urlHref = href.split('?');
      let pathFirst = urlHref[0].substr(0, urlHref[0].lastIndexOf('/'));
      const areaParts = urlHref[0].substr(urlHref[0].lastIndexOf('/') + 1, urlHref[0].length);
      const city = pathFirst.substr(pathFirst.lastIndexOf('/') + 1, pathFirst.length);
      pathFirst = pathFirst.substr(0, pathFirst.lastIndexOf('/'));
      const listType = pathFirst.substr(pathFirst.lastIndexOf('/') + 1, pathFirst.length);

      let queryUrl = `/${listType}/${city}/${areaParts}?sort=${this.sortBy}`;
      this.router.navigateByUrl(queryUrl)
    }
  }



  setSearchParams(params: Params): boolean {
    if (JSON.stringify(params) === JSON.stringify(this.searchParams)) {
      return false;
      // Do nothing..
    } else {
      this.properties = [];
      this.properties$ = new Subject<Property[]>();
      this.searchParams = params;
      this.page = 1;
      return true;
    }
  }

  getProperties(): Observable<Property[]> {
    return this.properties$.asObservable();
  }

  getLocation(): Observable<Location> {
    return this.location$.asObservable();
  }

  resumeProperties() {
    this.properties$.next(this.properties);
    this.location$.next(this.location);
  }

  searchProperties() {
    const newParams: Params = {};
    for (const param in this.searchParams) {
      newParams[param] = this.searchParams[param];
    }
    newParams['page'] = this.page;
    if (this.page === 1) {
      this.searchingProperty.next(true);
      this.propertyService.searchProperties(newParams, 'SEARCH').subscribe((properties) => {
        this.listCount.next(properties['count']);
        this.locationsProp.next(properties['locations']);
        this.searchLocations.next(properties['searchLocations']);
        this.parents.next(properties['parents']);
        this.properties = properties['properties'];
        this.properties$.next(properties['properties']);
        this.searchingProperty.next(false);
      });
    } else {
      this.isLoading.next(true);
      this.propertyService.searchProperties(newParams, 'SEARCH').subscribe((properties) => {
        this.listCount.next(properties['count']);
        this.locationsProp.next(properties['locations']);
        this.searchLocations.next(properties['searchLocations']);
        this.parents.next(properties['parents']);
        this.properties = this.properties.concat(properties['properties']);
        this.properties$.next(this.properties);
        this.searchingProperty.next(false);
        this.isLoading.next(false);
      });
    }
  }

  loadMore() {
    this.page++;
    this.searchProperties();
  }
}
