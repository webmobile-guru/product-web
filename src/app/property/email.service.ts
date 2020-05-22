import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class EmailService {
  private backendServer = environment.API;
  private propertiesUrl = 'properties/';

  constructor(private http: HttpClient) {}

  sendEmail(propertyId: string, email: object): Observable<Object> {
    const url = this.backendServer + this.propertiesUrl + propertyId + '/sendEmail';
    return this.http.post<Object>(url, email).pipe(catchError(this.handleError<Object>('recordLead', [])));
  }

  private handleError<T>(operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
      console.log(error);
      return of(result as T);
    };
  }
}
