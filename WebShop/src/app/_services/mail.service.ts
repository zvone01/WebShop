import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class MailService {

  constructor(private http: HttpClient) { }

  send(data: any) {

    if(localStorage.getItem("selectionType") == "reservationCode") 
    {
     // console.log("Kod");
      return this.http.post(`${environment.apiUrl}/mail/sendKod.php`, data);
    }
    else if(localStorage.getItem("selectionType") == "dateAndMeal")
    {
     // console.log("IstiDatum");
      return this.http.post(`${environment.apiUrl}/mail/send2.php`, data);
    }
    else if(localStorage.getItem("selectionType") == "meal")
    {
     // console.log("SamoDatum");
      return this.http.post(`${environment.apiUrl}/mail/sendDate.php`, data);
    }
    return;
    
  }

}
