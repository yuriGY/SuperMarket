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
import { HeaderComponent } from '../../shared/layout/header/header.component';
import { PageComponent } from '../../shared/layout/page/page.component';

@Component({
  selector: 'app-types-form',
  imports: [PageComponent, HeaderComponent, MatInputModule, MatSelectModule, MatButtonModule, MatFormFieldModule, ReactiveFormsModule],
  templateUrl: './types-form.component.html',
  styleUrls: ['./types-form.component.scss']
})
export class TypesFormComponent implements OnDestroy {
  form: FormGroup;
  isNew = true;
  id!: boolean;
  headerTitle!: string;
  productType!: IProductType;
  getProductTypeSubscription: Subscription | undefined;

  constructor(
    private router: Router, private route: ActivatedRoute, private http: HttpClient, private fb: FormBuilder
  ) {
    this.form = this.fb.group({
      name: ['', [Validators.required, Validators.minLength(1), Validators.maxLength(100)]],
      productTax: [0, [Validators.required, Validators.min(0)]]
    });
  }

  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.id = params['id'];
      if (!this.id) {
        this.headerTitle = 'Novo tipo de produto';

      } else {
        this.isNew = false;
        this.getProductType();
      }
    });
  }

  ngOnDestroy(): void {
    if (this.getProductTypeSubscription) this.getProductTypeSubscription.unsubscribe();
  }

  getProductType(): void {
    if (this.getProductTypeSubscription) this.getProductTypeSubscription.unsubscribe();
    this.getProductTypeSubscription = this.http.get<IProductType>(`http://localhost:8080/products_types/${this.id}`)
      .subscribe({
        next: (result) => {
          this.productType = result;
          this.headerTitle = this.productType.name;
          this.form.patchValue({
            name: this.productType.name,
            productTax: this.productType.producttax
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

    const productTypeData = this.form.value;
    if (this.isNew) {
      this.http.post('http://localhost:8080/products_types/', productTypeData)
        .subscribe({
          next: (result) => {
            alert((result as any).message);
            this.router.navigate(['/types']);
          },
          error: (error) => {
            alert(error.error.error);
          }
        });
    } else {
      this.http.put(`http://localhost:8080/products_types/${this.id}`, productTypeData)
        .subscribe({
          next: (result) => {
            alert((result as any).message);
            this.router.navigate(['/types']);
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
