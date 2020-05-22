import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Property } from '../property/model/property';
import { catchError } from 'rxjs/operators';
import { Observable, of } from 'rxjs';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class LeadService {
  private backendServer = environment.API;
  private leadUrl = 'lead';

  constructor(private http: HttpClient) {}

  recordLead(property: Property, leadType: string): Observable<Object> {
    const url = this.backendServer + this.leadUrl;
    const body = {
      type: leadType,
      property: property._id
    };
    return this.http.post<Object>(url, body).pipe(catchError(this.handleError<Object>('recordLead', [])));
  }

  private handleError<T>(operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
      console.log(error);
      return of(result as T);
    };
  }
}
