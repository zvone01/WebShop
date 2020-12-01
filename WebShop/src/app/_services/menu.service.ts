import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Menu, Product } from '../_models';
import { environment } from '../../environments/environment';
import { Observable, of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class MenuService {

  constructor(private http: HttpClient) { }


  getAll(): Observable<Menu[]> {
    return this.http.get<Menu[]>(`${environment.apiUrl}/menu/read.php`);
  }
  getOne(id: number): Observable<Menu> {
    return this.http.get<Menu>(`${environment.apiUrl}/menu/read_one.php?id=` + id);
  }
  create(menu: Menu) {
    return this.http.post(`${environment.apiUrl}/menu/create.php`, menu);
  }

  delete(ID: number) {
    return this.http.post(`${environment.apiUrl}/menu/delete.php`, { "ID": ID });
  }

  update(menu: Menu) {
    return this.http.post(`${environment.apiUrl}/menu/update.php`, menu);
  }

  addProducts(menuID: number, Product: number[]) {
    return this.http.post(`${environment.apiUrl}/menu/add_products.php`, {"menuID": menuID, "Products": Product});
  }

  removeProducts(menuID: number, Product: number[]) {
    return this.http.post(`${environment.apiUrl}/menu/remove_products.php`, {"menuID": menuID, "Products": Product});
  }
}
