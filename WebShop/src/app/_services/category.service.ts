import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Category } from '../_models';
import { environment } from '../../environments/environment';
import { Observable, of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class CategoryService {

  constructor(private http: HttpClient) { }


  getAll(): Observable<Category[]> {
    return this.http.get<Category[]>(`${environment.apiUrl}/category/read.php`);

  }

  
  getMenu(): Observable<Category[]> {
    return this.http.get<Category[]>(`${environment.apiUrl}/category/readMenu.php`);

  }

  create(category: Category) {
    return this.http.post(`${environment.apiUrl}/category/create.php`, category);
  }

  readHighestOrdinal() {
    return this.http.get<number>(`${environment.apiUrl}/category/readHighestOrder.php`);
  }

  delete(ID: number) {
    return this.http.post(`${environment.apiUrl}/category/delete.php`, ID);
  }
  up(ID: number) {
    return this.http.post(`${environment.apiUrl}/category/up.php`, { "ID": ID });
  }
  down(ID: number) {
    return this.http.post(`${environment.apiUrl}/category/down.php`, { "ID": ID });
  }

  deleteMultiple(ID: number[]) {
    return this.http.post(`${environment.apiUrl}/category/deleteMultiple.php`, { "ID": ID });
  }
  /*
    upload(imageFile: File, ID: Number) {
      const uploadData = new FormData();
      uploadData.append('upfile', imageFile, ID.toString());
     return this.http.post(`${environment.apiUrl}/category/upload.php`, uploadData);
    }*/

  update(category: Category) {
    return this.http.post(`${environment.apiUrl}/category/update.php`, category);
  }
  /*
    uploadImage(imageFile: File) {
      const uploadData = new FormData();
      uploadData.append('upfile', imageFile, imageFile.name);
      
      return this.http.post(`${environment.apiUrl}/category/uploadNew.php`, uploadData);
    }*/
}
