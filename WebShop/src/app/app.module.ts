import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule} from "@angular/platform-browser/animations";
import { HttpModule } from '@angular/http';
import { FormsModule, ReactiveFormsModule} from '@angular/forms';
import { SlickModule } from 'ngx-slick';
import { DirectivesModule } from './core/directive/directives.module';

import { OwlDateTimeModule, OwlNativeDateTimeModule } from 'ng-pick-datetime';
 

/* Routing */
import { AppRoutingModule } from './app-routing.module';



/* components */
import { AppComponent } from './app.component';
import { HomeComponent } from './home/home.component';
import { FooterComponent } from './footer/footer.component';
import { HeaderComponent } from './header/header.component';
import { MenuComponent } from './menu/menu.component';
 
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { AlertComponent } from './_directives';
import { AuthGuard } from './_guards';
import { JwtInterceptor, ErrorInterceptor } from './_helpers';
import { AlertService, AuthenticationService, UserService, ProductService, CategoryService, ProductVariantService } from './_services';
import { LoginComponent } from './login';
import { RegisterComponent } from './register';

import { MainComponent } from './main/main.component';
import { MenuItems } from './core/menu/menu-items/menu-items';
import { MenuToggleModule } from './core/menu-toggle.module';
import { PageTitleService } from './core/page-title/page-title.service';
import { WidgetsModule } from './widgets/widgets.module';
import { Footer2Component } from './footer2/footer2.component';
import { AdminMenuComponent } from './admin-menu/admin-menu.component';
import { ProductViewComponent } from './product-view/product-view.component';
import { CategoryViewComponent } from './category-view/category-view.component';
import { ShopComponent } from './shop/shop.component';
import { StepComponent } from './step/step.component';
import { MenuViewComponent } from './menu-view/menu-view.component';
import { MenuSelectComponent } from './menu-select/menu-select.component';
import { MenuProductComponent } from './menu-product/menu-product.component';
import { ProductEditComponent } from './product-edit/product-edit.component';
import { ThankYouComponent } from './thankYou/thankYou.component';
/* matrial modules */
import { MatSlideToggleModule } from '@angular/material';
import { UserAdminComponent } from './user-admin/user-admin.component';
import { ResetPassComponent } from './reset-pass/reset-pass.component';
import { ResetPassMenuComponent } from './reset-pass-menu/reset-pass-menu.component';
import { AdminCalendarComponent } from './admin-calendar/admin-calendar.component';
import { DateSelectComponent } from './date-select/date-select.component';
import { Page3Component } from './page3/page3.component';


@NgModule({
  declarations: [
    MainComponent,
    MenuComponent,
    ThankYouComponent,
    AppComponent,
    AlertComponent,
    HomeComponent,
    LoginComponent,
    RegisterComponent,
    HomeComponent,
    FooterComponent,
    HeaderComponent,
    Footer2Component,
    AdminMenuComponent,
    ProductViewComponent,
    CategoryViewComponent,
    ShopComponent,
    StepComponent,
    MenuViewComponent,
    MenuSelectComponent,
    MenuProductComponent,
    ProductEditComponent,
    MainComponent,
    UserAdminComponent,
    ResetPassComponent,
    ResetPassMenuComponent,
    AdminCalendarComponent,
    DateSelectComponent,
    Page3Component
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule,
    HttpModule,
    AppRoutingModule,
    WidgetsModule,
    MenuToggleModule,
	  DirectivesModule,
    SlickModule.forRoot(),
    OwlDateTimeModule, 
    OwlNativeDateTimeModule,
    MatSlideToggleModule
  ],
  providers: [
    MenuItems,
    PageTitleService,
    AuthGuard,
    AlertService,
    AuthenticationService,
    UserService,
    { provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true },
    ProductService,
    { provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true },
    ProductVariantService,
    { provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true },
    CategoryService,
    { provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true },

    // provider used to create fake backend
    //fakeBackendProvider
],
  bootstrap: [AppComponent]
})
export class AppModule { }
