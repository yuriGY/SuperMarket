import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CartSaleComponent } from './cart/cart-sale/cart-sale.component';
import { ProductsFormComponent } from './products/products-form/products-form.component';
import { ProductsListComponent } from './products/products-list/products-list.component';
import { TypesFormComponent } from './types/types-form/types-form.component';
import { TypesListComponent } from './types/types-list/types-list.component';

export const routes: Routes = [
  { path: '', component: CartSaleComponent },
  { path: 'products', component: ProductsListComponent },
  { path: 'products/new', component: ProductsFormComponent },
  { path: 'products/:id', component: ProductsFormComponent },
  { path: 'types', component: TypesListComponent },
  { path: 'types/new', component: TypesFormComponent },
  { path: 'types/:id', component: TypesFormComponent },
  { path: '**', redirectTo: '' }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
