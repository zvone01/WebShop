import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CommonModule } from '@angular/common';
import { AuthGuard } from './_guards/index';

import { HomeComponent } from './home/home.component';
import { LoginComponent } from './login/login.component';
import { AdminMenuComponent } from './admin-menu/admin-menu.component';
import { ProductViewComponent } from './product-view/product-view.component';
import { CategoryViewComponent } from './category-view/category-view.component';
import { ShopComponent } from './shop/shop.component';
import { StepComponent } from './step/step.component';
import { MenuViewComponent } from './menu-view/menu-view.component';
import { MenuSelectComponent } from './menu-select/menu-select.component';
import { MenuProductComponent } from './menu-product/menu-product.component';
import { ProductEditComponent } from './product-edit/product-edit.component';
import { MainComponent } from './main/main.component';
import { ThankYouComponent } from './thankYou/thankYou.component';
import { UserAdminComponent } from './user-admin/user-admin.component';
import { ResetPassComponent } from './reset-pass/reset-pass.component';
import { ResetPassMenuComponent } from './reset-pass-menu/reset-pass-menu.component';
import { AdminCalendarComponent } from './admin-calendar/admin-calendar.component';
import { DateSelectComponent } from './date-select/date-select.component';
import { Page3Component } from './page3/page3.component';

export const appRoutes: Routes = [
  { path: '', redirectTo: '/home', pathMatch: 'full' },
  {
    path: '', component: MainComponent,
    children: [
      { path: 'admin-menu', component: AdminMenuComponent, canActivate: [AuthGuard] },
      { path: 'admin-calendar', component: AdminCalendarComponent, canActivate: [AuthGuard] },
      { path: 'product-view', component: ProductViewComponent, canActivate: [AuthGuard] },
      { path: 'category-view', component: CategoryViewComponent, canActivate: [AuthGuard] },
    //  { path: 'menu-view', component: MenuViewComponent, canActivate: [AuthGuard] },
    //  { path: 'menu-product/:Id', component: MenuProductComponent, canActivate: [AuthGuard] },
    //  { path: 'product-edit/:Id', component: ProductEditComponent, canActivate: [AuthGuard] },
      { path: 'user-admin', component: UserAdminComponent, canActivate: [AuthGuard] },
      { path: 'menu-select', component: MenuSelectComponent },
      //{ path: 'shop', component: ShopComponent },
      { path: 'shop/:Id', component: StepComponent },
      { path: 'home', component: HomeComponent },
      { path: 'page3', component: Page3Component },
      { path: 'date', component: DateSelectComponent },
      { path: 'login', component: LoginComponent },
      { path: 'thankyou', component: ThankYouComponent},
      { path: 'reset-pass', component: ResetPassComponent},
      { path: 'reset-pass-menu/:Token', component: ResetPassMenuComponent},
      { path: '', loadChildren: './session/session.module#SessionModule' },
      { path: '', loadChildren: './shop/shop.module#ShopModule' }
    ]
  }];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forRoot(appRoutes)
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
