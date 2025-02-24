import { HttpClient } from '@angular/common/http';
import { Component, OnDestroy } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatSelectModule } from '@angular/material/select';
import { ActivatedRoute, Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { IProductType } from '../../shared/interfaces/product-type.interface';
import { IProduct } from '../../shared/interfaces/product.interface';
import { HeaderComponent } from '../../shared/layout/header/header.component';
import { PageComponent } from '../../shared/layout/page/page.component';

@Component({
  selector: 'app-products-form',
  imports: [PageComponent, HeaderComponent, MatInputModule, MatSelectModule, MatButtonModule, MatFormFieldModule, ReactiveFormsModule],
  templateUrl: './products-form.component.html',
  styleUrls: ['./products-form.component.scss']
})
export class ProductsFormComponent implements OnDestroy {
  form: FormGroup;
  isNew = true;
  id!: boolean;
  headerTitle!: string;
  productsTypes!: IProductType[];
  product!: IProduct;
  getTypesSubscription: Subscription | undefined;
  getProductSubscription: Subscription | undefined;

  constructor(
    private router: Router, private route: ActivatedRoute, private http: HttpClient, private fb: FormBuilder
  ) {
    this.form = this.fb.group({
      name: ['', [Validators.required, Validators.minLength(1), Validators.maxLength(100)]],
      productTypeId: ['', [Validators.required]],
      stock: [0, [Validators.required, Validators.min(0)]],
      cost: [0, [Validators.required, Validators.min(0)]]
    });
  }

  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.id = params['id'];

      this.getTypes();
    });
  }

  ngOnDestroy(): void {
    if (this.getTypesSubscription) this.getTypesSubscription.unsubscribe();
    if (this.getProductSubscription) this.getProductSubscription.unsubscribe();
  }

  getTypes(): void {
    if (this.getTypesSubscription) this.getTypesSubscription.unsubscribe();
    this.getTypesSubscription = this.http.get<IProductType[]>('http://localhost:8080/products_types/')
      .subscribe({
        next: (result) => {
          this.productsTypes = result;

          if (!this.id) {
            this.headerTitle = 'Novo produto';
            this.productsTypes = this.productsTypes.filter((pt) => !pt.removed);
          } else {
            this.productsTypes.forEach((pt) => {
              if (pt.removed) pt.name = `${pt.name} [Removido]`;
            });

            this.isNew = false;
            this.getProduct();
          }
        },
        error: (error) => {
          alert(error.error.error);
        }
      });
  }

  getProduct(): void {
    if (this.getProductSubscription) this.getProductSubscription.unsubscribe();
    this.getProductSubscription = this.http.get<IProduct>(`http://localhost:8080/products/${this.id}`)
      .subscribe({
        next: (result) => {
          this.product = result;
          this.headerTitle = this.product.name;
          this.productsTypes = this.productsTypes.filter((pt) => !pt.removed || pt.id === this.product.typeid);
          this.form.patchValue({
            name: this.product.name,
            productTypeId: this.product.typeid,
            stock: this.product.stock,
            cost: this.product.cost
          });
        },
        error: (error) => {
          alert(error.error.error);
        }
      });
  }

  save(): void {
    if (this.form.invalid) {
      return;
    }

    const productData = this.form.value;
    if (this.isNew) {
      this.http.post('http://localhost:8080/products/', productData)
        .subscribe({
          next: (result) => {
            alert((result as any).message);
            this.router.navigate(['/products']);
          },
          error: (error) => {
            alert(error.error.error);
          }
        });
    } else {
      this.http.put(`http://localhost:8080/products/${this.id}`, productData)
        .subscribe({
          next: (result) => {
            alert((result as any).message);
            this.router.navigate(['/products']);
          },
          error: (error) => {
            alert(error.error.error);
          }
        });
    }
  }

  isValid(): boolean {
    return this.form.valid;
  }
}
