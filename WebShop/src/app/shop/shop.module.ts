import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule  } from '@angular/forms';
import { OwlDateTimeModule, OwlNativeDateTimeModule } from 'ng-pick-datetime';


import { ShopRoutes } from './shop.routing';
import { WidgetsModule } from '../widgets/widgets.module';

import { ProductCartComponent } from './productCart/productCart.component';
import { ProductCheckoutComponent } from './productCheckout/productCheckout.component';
import { ProductDetailComponent } from './productDetail/productDetail.component';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    ReactiveFormsModule ,
    OwlDateTimeModule, 
    OwlNativeDateTimeModule,
    RouterModule.forChild(ShopRoutes),
    WidgetsModule
  ],
  declarations: [
  	ProductCartComponent,
  	ProductCheckoutComponent,
  	ProductDetailComponent
  ]
})

export class ShopModule {}
