import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';


import { Observable, of } from 'rxjs';

import { environment } from '../../environments/environment';
import { ProductVariant, Product } from '../_models';
import { Alert } from '../../../node_modules/@types/selenium-webdriver';

@Injectable({
  providedIn: 'root'
})
export class ProductVariantService {

  constructor(private http: HttpClient) { }

  getByProductID(ID: number): Observable<ProductVariant[]> {
    return this.http.get<ProductVariant[]>(`${environment.apiUrl}/product-variant/read.php?productID=` + ID);
    //return this.http.get('content.json');
  }

  create(product: ProductVariant) {
    return this.http.post(`${environment.apiUrl}/product-variant/create.php`, product);
  }

  update(product: ProductVariant) {
    return this.http.post(`${environment.apiUrl}/product-variant/update.php`, product);
  }

  
  updateDefault(product: Product) {
    return this.http.post(`${environment.apiUrl}/product-variant/updateDefault.php`, product);
  }

  delete(ID: number) {
    return this.http.post(`${environment.apiUrl}/product-variant/delete.php`, ID);
  }


}
