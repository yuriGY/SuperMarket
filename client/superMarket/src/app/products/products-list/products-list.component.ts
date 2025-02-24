import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component, ElementRef, OnDestroy, ViewChild } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatIconModule } from '@angular/material/icon';
import { MatInputModule } from '@angular/material/input';
import { MatTableDataSource, MatTableModule } from '@angular/material/table';
import { Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { SearchBarComponent } from '../../shared/components/search-bar/search-bar.component';
import { IProduct } from '../../shared/interfaces/product.interface';
import { HeaderComponent } from '../../shared/layout/header/header.component';
import { PageComponent } from '../../shared/layout/page/page.component';

@Component({
  selector: 'app-products-list',
  imports: [PageComponent, MatInputModule, MatFormFieldModule, MatTableModule, FormsModule, SearchBarComponent, HeaderComponent, CommonModule, MatIconModule],
  templateUrl: './products-list.component.html',
  styleUrls: ['./products-list.component.scss']
})
export class ProductsListComponent implements OnDestroy {
  @ViewChild('container') containerRef!: ElementRef;

  getProductsSubscription: Subscription | undefined;

  displayedColumns: string[] = ['name', 'cost', 'stock', 'typename', 'delete'];
  searchQuery!: string;
  tableMaxHeight!: string;
  products = new MatTableDataSource<IProduct>([]);

  constructor(private router: Router, private http: HttpClient, private cdr: ChangeDetectorRef) { }

  ngOnInit(): void {
    this.getProducts();
  }

  ngOnDestroy(): void {
    if (this.getProductsSubscription) this.getProductsSubscription.unsubscribe();
  }

  getProducts(): void {
    if (this.getProductsSubscription) this.getProductsSubscription.unsubscribe();
    this.getProductsSubscription = this.http.get<IProduct[]>('http://localhost:8080/products/')
      .subscribe({
        next: (result) => {
          this.products.data = result;
        },
        error: (error) => {
          alert(error.error.error);
        }
      });
  }

  onRowClick(event: MouseEvent, productId: string): void {
    if ((event.target as HTMLElement).tagName === 'BUTTON' || (event.target as HTMLElement).tagName === 'MAT-ICON') return;

    this.router.navigate(['/products', productId]);
  }

  setTableMaxHeight(toolbarHeight: number): void {
    const occupiedHeight = toolbarHeight + this.containerRef.nativeElement.offsetHeight;
    this.tableMaxHeight = `calc(100vh - ${occupiedHeight}px)`;
    this.cdr.detectChanges();
  }

  delete(productId: string): void {
    if (confirm('Tem certeza que deseja excluir este produto?')) {
      this.http.delete(`http://localhost:8080/products/${productId}`).subscribe({
        next: (result) => {
          alert((result as any).message);
          this.getProducts();
        },
        error: (error) => {
          alert(error.error.error);
        }
      });
    }
  }
}
