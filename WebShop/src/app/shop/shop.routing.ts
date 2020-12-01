import { Routes } from '@angular/router';
import { ProductCartComponent } from './productCart/productCart.component';
import { ProductCheckoutComponent } from './productCheckout/productCheckout.component';
import { ProductDetailComponent } from './productDetail/productDetail.component';

export const ShopRoutes: Routes = [{
  path: '',
  redirectTo: 'productlist',
  pathMatch: 'full',
}, {
  path: '',
  children:
  [{ path: 'product-cart', component: ProductCartComponent },
  { path: 'product-checkout', component: ProductCheckoutComponent },
  { path: 'product-detail/:Id/:variantId', component: ProductDetailComponent }]
}];