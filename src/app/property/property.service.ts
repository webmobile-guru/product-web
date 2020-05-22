import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';

import { Property } from './model/property';
import { catchError, tap } from 'rxjs/operators';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class PropertyService {
  private backendServer = environment.API;
  private propertiesUrl = 'properties';

  constructor(private http: HttpClient) {}

  searchProperties(search: object, source: string): Observable<Property[]> {
    // TODO : Change for search by agent with pagination
    let params = new HttpParams();
    const url = this.backendServer + this.propertiesUrl;
    if (source) {
      search['source'] = source;
    }
    Object.entries(search).forEach(([key, value]) => {
      if (value) {
        params = params.append(key, value);
      }
    });
    return this.http
      .get<Property[]>(url, { params })
      .pipe(catchError(this.handleError<Property[]>('searchProperties', [])));
  }

  getAllProperties(query) {
    if (query !== null) query = query.substr(1, query.length);
    return this.http.get<any>(this.backendServer + this.propertiesUrl + (query !== null ? '?' + query : ''));
  }

  getSimilarProperties(id) {
    return this.http.get<any>(`${this.backendServer}${this.propertiesUrl}/${id}/similar`);
  }

  getPropertyById(id) {
    return this.http.get<any>(this.backendServer + this.propertiesUrl + '/' + id);
  }

  getPropertyByShortId(id) {
    return this.http.get<any>(this.backendServer + this.propertiesUrl + '/short/' + id);
  }

  private handleError<T>(operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
      console.log(error);
      return of(result as T);
    };
  }
}
