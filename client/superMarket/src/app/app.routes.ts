import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { TypesListComponent } from './types/types-list/types-list.component';
import { TypesFormComponent } from './types/types-form/types-form.component';
import { ProductsListComponent } from './products/products-list/products-list.component';
import { ProductsFormComponent } from './products/products-form/products-form.component';
import { CheckoutComponent } from './cart/checkout/checkout.component';
import { CartSaleComponent } from './cart/cart-sale/cart-sale.component';

export const routes: Routes = [
  { path: '', component: CartSaleComponent },
  { path: 'checkout/:id', component: CheckoutComponent },
  { path: 'products', component: ProductsListComponent }, 
  { path: 'products/:id', component: ProductsFormComponent },
  { path: 'types', component: TypesListComponent }, 
  { path: 'types/:id', component: TypesFormComponent },
  { path: '**', redirectTo: '' }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
