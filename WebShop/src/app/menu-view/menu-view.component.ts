import { Component, OnInit } from '@angular/core';
import { first } from 'rxjs/operators';
import { Product, Menu } from '../_models';
import { MenuService,CategoryService } from '../_services';
import {  } from '../_services';
import { Category } from '../_models';

import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { AlertService } from '../_services';
import { Alert } from '../../../node_modules/@types/selenium-webdriver';

@Component({
  selector: 'app-menu-view',
  templateUrl: './menu-view.component.html',
  styleUrls: ['./menu-view.component.css']
})
export class MenuViewComponent implements OnInit {

  Menus: Menu[];
  currentID: Number;
  alert: Alert;

  createMenuForm: FormGroup;
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
    this.createMenuForm = this.formBuilder.group({
      Name: ['', Validators.required],
      Description: ['', Validators.required],
      Price: [0, Validators.required]
    });
  }

  get f() { return this.createMenuForm.controls; }


  private loadAllMenus() {
    this.menuService.getAll()
      .subscribe(x => {
        this.Menus = x['Menu'];
      });
  };

  change(menu) {
    this.menuService.update(menu)
      .subscribe(

        data => {
          this.alertService.success(data["message"]);
        },
        error => {
          this.alertService.error(error);
          this.loading = false;

        });
  }

  delete(ID) {
    this.menuService.delete(ID)
      .subscribe(
        data => {
          this.alertService.success(data["message"]);
          this.loadAllMenus();
        },
        error => {
          this.alertService.error(error);
          this.loading = false;

        }
      );
  }

  edit(ID)
  {
    this.router.navigate(["menu-product/"+ID]);
  }

  onSubmit() {
    this.submitted = true;
    if (this.createMenuForm.invalid) {
      this.alertService.warn("Form error");
      return;
    }
    this.loading = true;

    this.menuService.create(this.createMenuForm.value)
      .pipe(first())
      .subscribe(
        data => {
          this.alertService.success(data["message"]);
          this.loadAllMenus();
          
        },
        error => {
          this.alertService.error(error["message"]);

        });
  }

}
