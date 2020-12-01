import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Calendar } from '../_models';
import { environment } from '../../environments/environment';
import { Observable, of } from 'rxjs';


@Injectable({
  providedIn: 'root'
})
export class CalendarService {


  constructor(private http: HttpClient) { }

  getAll(): Observable<Calendar[]> {
    return this.http.get<Calendar[]>(`${environment.apiUrl}/calendar/read.php`);

  }
  create(Calendar: Date) {
    return this.http.post(`${environment.apiUrl}/calendar/create.php`, {"Date": Calendar.toJSON().split('T')[0]});
  }

  delete(ID: number) {
    return this.http.post(`${environment.apiUrl}/calendar/delete.php`,{"ID":ID});
  }

}
