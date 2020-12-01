import { Component, OnInit } from '@angular/core';
import { Product, Menu, Cart } from '../_models';
import { MenuService,CategoryService } from '../_services';

import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { AlertService } from '../_services';
import { Alert } from '../../../node_modules/@types/selenium-webdriver';

@Component({
  selector: 'app-menu-select',
  templateUrl: './menu-select.component.html',
  styleUrls: ['./menu-select.component.css']
})
export class MenuSelectComponent implements OnInit {

  Menus: Menu[];
  alert: Alert;

  loading = false;
  submitted = false;

  constructor(private menuService: MenuService,
    private formBuilder: FormBuilder,
    private router: Router,
    private alertService: AlertService
  ) {
  }

  ngOnInit() {
    this.loadAllMenus();
  }


  private loadAllMenus() {
    this.menuService.getAll()
      .subscribe(x => {
        this.Menus = x['Menu'];
      });
  };

  private selectMenu(menuId)
  {
   
    localStorage.removeItem('cart');
    this.Menus['Menu'].filter(m => m.ID == menuId)[0]['Products'].forEach(element => {
      this.addToCart(element);
      
    });
  }

  private addToCart(product: Product) {
    let flag: boolean;
    flag = false;

    let productLocalStorageArray: Cart[] = JSON.parse(localStorage.getItem('cart')) || [];

    productLocalStorageArray.forEach(element => {
      if (element.Product.ID == product.ID) {
        element.Count += 1;
        flag = true;
      }
    });
    if (!flag) {
      let newCart: Cart;
      newCart = new Cart();
      newCart.Product = product;
      newCart.Count = Number(localStorage.getItem('personNumber'));
      productLocalStorageArray.push(newCart);
    }
    localStorage.setItem('cart', JSON.stringify(productLocalStorageArray));

    this.router.navigate(['/product-cart']);
  }
}
