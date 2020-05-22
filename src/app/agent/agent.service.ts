import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { Agent } from './model/agent';
import { catchError, tap } from 'rxjs/operators';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class AgentService {
  private backendServer = environment.API;
  private agentUrl = 'agents';

  constructor(private http: HttpClient) {}

  getAgent(id: string): Observable<Agent> {
    const url = `${this.backendServer}${this.agentUrl}/${id}`;
    return this.http.get<Agent>(url).pipe(catchError(this.handleError<Agent>(`getAgent id=${id}`)));
  }

  getAgents(agencyId: string): Observable<Agent[]> {
    const params = new HttpParams();
    const url = this.backendServer + this.agentUrl;
    params.append('agency', agencyId);
    return this.http.get<Agent[]>(url, { params }).pipe(catchError(this.handleError<Agent[]>('getAgents', [])));
  }

  private handleError<T>(operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
      console.log(error);
      return of(result as T);
    };
  }
}
