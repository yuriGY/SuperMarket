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
import { IProductType } from '../../shared/interfaces/product-type.interface';
import { HeaderComponent } from '../../shared/layout/header/header.component';
import { PageComponent } from '../../shared/layout/page/page.component';

@Component({
  selector: 'app-types-list',
  imports: [PageComponent, MatInputModule, MatFormFieldModule, MatTableModule, FormsModule, SearchBarComponent, HeaderComponent, CommonModule, MatIconModule],
  templateUrl: './types-list.component.html',
  styleUrls: ['./types-list.component.scss']
})
export class TypesListComponent implements OnDestroy {
  @ViewChild('container') containerRef!: ElementRef;

  getTypesSubscription: Subscription | undefined;

  displayedColumns: string[] = ['name', 'producttax', 'delete'];
  searchQuery!: string;
  tableMaxHeight!: string;
  productsTypes = new MatTableDataSource<IProductType>([]);

  constructor(private router: Router, private http: HttpClient, private cdr: ChangeDetectorRef) { }

  ngOnInit(): void {
    this.getTypes();
  }

  ngOnDestroy(): void {
    if (this.getTypesSubscription) this.getTypesSubscription.unsubscribe();
  }

  getTypes(): void {
    if (this.getTypesSubscription) this.getTypesSubscription.unsubscribe();
    this.getTypesSubscription = this.http.get<IProductType[]>('http://localhost:8080/products_types/')
      .subscribe({
        next: (result) => {
          this.productsTypes.data = result;
          this.productsTypes.data = this.productsTypes.data.filter((pt) => !pt.removed);
        },
        error: (error) => {
          alert(error.error.error);
        }
      });
  }

  onRowClick(event: MouseEvent, typeId: string): void {
    if ((event.target as HTMLElement).tagName === 'BUTTON' || (event.target as HTMLElement).tagName === 'MAT-ICON') return;

    this.router.navigate(['/types', typeId]);
  }

  setTableMaxHeight(toolbarHeight: number): void {
    const occupiedHeight = toolbarHeight + this.containerRef.nativeElement.offsetHeight;
    this.tableMaxHeight = `calc(100vh - ${occupiedHeight}px)`;
    this.cdr.detectChanges();
  }

  delete(typeId: string): void {
    if (confirm('Tem certeza que deseja excluir este tipo de produto?')) {
      this.http.delete(`http://localhost:8080/products_types/${typeId}`).subscribe({
        next: (result) => {
          alert((result as any).message);
          this.getTypes();
        },
        error: (error) => {
          alert(error.error.error);
        }
      });
    }
  }
}