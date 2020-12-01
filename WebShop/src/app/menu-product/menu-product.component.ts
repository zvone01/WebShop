import { Component, OnInit } from '@angular/core';
import { ProductService } from '../_services';
import { Product, Menu } from '../_models';

import { ActivatedRoute } from '@angular/router';
import { AlertService, MenuService } from '../_services';
import { Alert } from '../../../node_modules/@types/selenium-webdriver';
import { environment } from '../../environments/environment';

@Component({
  selector: 'app-menu-product',
  templateUrl: './menu-product.component.html',
  styleUrls: ['./menu-product.component.css']
})
export class MenuProductComponent implements OnInit {

  SelectedProduct: Product;
  AllProducts: Product[];
  Menu: Menu;
  selectedProductId: number;
  currentID: number;
  alert: Alert;


  constructor(private productService: ProductService,
    private alertService: AlertService,
    private menuService: MenuService,
    private activatedRoute: ActivatedRoute,
  ) {
    this.Menu = new Menu();
    this.SelectedProduct = new Product();
  }

  ngOnInit() {
    this.currentID = Number(this.activatedRoute.snapshot.paramMap.get('Id'));
    this.loadMenu(this.currentID);
    this.loadAllProducts();

  }

  private loadMenu(id) {
    this.menuService.getOne(id).subscribe(m => { this.Menu = m; });
  }
  private loadAllProducts() {
    this.productService.getAll()
      .subscribe(x => {
        this.AllProducts = x['Product'];
        this.SelectedProduct = x['Product'][0];
      });


  };

  addMenu(menuID, SelectedProduct) {
    this.menuService.addProducts(menuID, Array(SelectedProduct)).subscribe(data => {
      this.loadMenu(this.currentID);
      this.alertService.success(data["message"]);
    },error => {this.alertService.error(error)});
  }

  getImage(picture): string {
		return `${environment.apiUrl}` + "/img/p/" + picture;
	}

  removeProduct(SelectedProductID: number) {

    this.menuService.removeProducts(this.Menu.ID, Array(SelectedProductID)).subscribe(data => {
      this.loadMenu(this.currentID);
    },error => {this.alertService.error(error)});
  }

  productSelect(id) {
    this.productService.getOneById(id).subscribe(p => this.SelectedProduct = p)
  }
}
