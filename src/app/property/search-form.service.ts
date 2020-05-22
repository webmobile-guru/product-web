import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { catchError, map } from 'rxjs/operators';
import { environment } from '../../environments/environment';
import { Subject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class SearchFormService {
  private backendServer = environment.API;
  private locationsUrl = 'locations';
  private formType = new Subject<string>();

  searchName : string;
  searchSlug : string;
  searchCheck : boolean = false;
  
  formType$ = this.formType.asObservable();

  constructor(private http: HttpClient) {}

  setFormType(formType: string) {
    this.formType.next(formType);
  }

  getLocation(search): Observable<Location> {
    const url = `${this.backendServer}${this.locationsUrl}?query=${search}`;
    return this.http.get<Location>(url).pipe(
      map((location) => {
        // location.isMulti = false;
        return location;
      }),
      catchError(this.handleError<Location>(`getLocation id=${search}`))
    );
  }

  private handleError<T>(operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
      // console.log(error);
      return of(result as T);
    };
  }

  postData(name,slug){
    this.searchName = name;
    this.searchSlug = slug;
    this.searchCheck = true;
  }
}
