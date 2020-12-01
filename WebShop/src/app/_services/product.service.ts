import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';


import { Observable, of } from 'rxjs';

import { environment } from '../../environments/environment';
import { Product, ProductVariant } from '../_models';
import { Alert } from '../../../node_modules/@types/selenium-webdriver';

@Injectable({ providedIn: 'root' })
export class ProductService {
  constructor(private http: HttpClient) { }

  getAll(): Observable<Product[]> {
    return this.http.get<Product[]>(`${environment.apiUrl}/product/read_default.php`);
    //return this.http.get('content.json');
  }

  getOne(ID: number): Observable<Product> {
    return this.http.get<Product>(`${environment.apiUrl}/product/read_one.php?id=` + ID);
    //return this.http.get('content.json');
  }

  getVariants(ID: number): Observable<ProductVariant[]> {
    return this.http.get<ProductVariant[]>(`${environment.apiUrl}/product-variant/read.php?productID=` + ID);
    //return this.http.get('content.json');
  }

  create(product: Product) {
    return this.http.post(`${environment.apiUrl}/product/create.php`, product);
  }

  createVariant(product: ProductVariant) {
    return this.http.post(`${environment.apiUrl}/product-variant/create.php`, product);
  }

  upload(imageFile: File, ID: Number) {
    const uploadData = new FormData();
    uploadData.append('upfile', imageFile, ID.toString());
    return this.http.post(`${environment.apiUrl}/product/upload.php`, uploadData);
  }

  uploadImage(imageFile: File) {
    const uploadData = new FormData();
    uploadData.append('upfile', imageFile, imageFile.name);
    
    return this.http.post(`${environment.apiUrl}/product/upload_new.php`, uploadData);
  }

  update(product: Product) {
    return this.http.post(`${environment.apiUrl}/product/update.php`, product);
  }

  deletePicture(ID: Number) {
    return this.http.post(`${environment.apiUrl}/product/delete_picture.php`, ID);
  }

  delete(ID: number) {
    return this.http.post(`${environment.apiUrl}/product/delete.php`, ID);
  }

  getByCategoryID(categoryID: number) {
    return this.http.get<Product[]>(`${environment.apiUrl}/product/read.php?categoryID=` + categoryID);
  }

  getByCategoryOrdinalNumber(num: number) {
    return this.http.get<Product[]>(`${environment.apiUrl}/product/read_with_variants.php?categoryOrdinalNumber=` + num);
  }

  getOneById(id: number) :Observable<any> {
    return this.http.get<any>(`${environment.apiUrl}/product/read_one.php?id=` + id);
  }

  up(ID: number, CategoryId: number) {
    return this.http.post(`${environment.apiUrl}/product/up.php`, {"ID":ID, "CategoryId": CategoryId});
  }
  down(ID: number, CategoryId: number) {
    return this.http.post(`${environment.apiUrl}/product/down.php`, {"ID":ID, "CategoryId": CategoryId});
  }


  getOneByIdWithVariants(id: number, vid: number) :Observable<any> {
    return this.http.get<any>(`${environment.apiUrl}/product/read_one_with_variant.php?id=` + id+ `&variantId=`+vid);
  }
}