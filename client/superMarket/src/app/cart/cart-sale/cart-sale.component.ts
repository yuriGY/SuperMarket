import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component, ElementRef, OnInit, ViewChild } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatIconModule } from '@angular/material/icon';
import { MatSelectModule } from '@angular/material/select';
import { IPaymentType } from '../../shared/interfaces/payment-type.interface';
import { IProduct } from '../../shared/interfaces/product.interface';
import { HeaderComponent } from '../../shared/layout/header/header.component';
import { PageComponent } from '../../shared/layout/page/page.component';

@Component({
  selector: 'app-cart-sale',
  imports: [PageComponent, MatIconModule, MatFormFieldModule, HeaderComponent, CommonModule, FormsModule, MatSelectModule],
  templateUrl: './cart-sale.component.html',
  styleUrls: ['./cart-sale.component.scss']
})
export class CartSaleComponent implements OnInit {
  @ViewChild('container') containerRef!: ElementRef;

  hasItemsSelected: boolean = false;

  selectedPaymentType: string = '';
  matrixMaxHeight!: string;
  leftColumnHeight!: string;
  totalCost: number = 0;
  totalTaxes: number = 0;
  products: IProduct[] = [];
  selectedItems: IProduct[] = [];
  paymentTypes: IPaymentType[] = [
    { id: 'K3l8N5o1', name: 'Dinheiro' },
    { id: 'R6q2S9t4', name: 'Crédito' },
    { id: 'V7u1W3x5', name: 'Débito' },
    { id: 'Z9y4A2b6', name: 'Pix' }
  ];

  constructor(private http: HttpClient, private cdr: ChangeDetectorRef) { }

  ngOnInit(): void {
    this.getProducts();
  }

  getProducts(): void {
    this.http.get<IProduct[]>('http://localhost:8080/products/').subscribe({
      next: (result) => {
        this.products = result.map(product => ({ ...product, quantity: 0 }));
      },
      error: (error) => {
        alert(error.error.error);
      }
    });
  }

  increaseQuantity(product: IProduct): void {
    product.quantity++;
    this.updateSelectedItems(product);
  }

  decreaseQuantity(product: IProduct): void {
    if (product.quantity > 0) {
      product.quantity--;
      this.updateSelectedItems(product);
    }
  }

  updateSelectedItems(product: IProduct): void {
    const existingItem = this.selectedItems.find(item => item.id === product.id);
    if (existingItem) {
      existingItem.quantity = product.quantity;

      if (existingItem.quantity === 0) {
        this.selectedItems = this.selectedItems.filter(item => item.id !== product.id);
      }
    } else {
      this.selectedItems.push({ ...product });
    }

    this.hasItemsSelected = this.selectedItems.length > 0;
    this.calculateTotals();
  }

  calculateTotals(): void {
    this.totalCost = this.selectedItems.reduce((sum, item) => sum + (item.cost * item.quantity), 0);
    this.totalTaxes = this.selectedItems.reduce((sum, item) => sum + (item.cost * item.quantity * (item.tax / 100)), 0);
  }

  finalizeSale(): void {
    if (!this.selectedItems.length) {
      alert('Nenhum produto selecionado para venda.');
      return;
    }

    if (!this.selectedPaymentType) {
      alert('Selecione uma forma de pagamento.');
      return;
    }

    const saleData = {
      paymentTypeId: this.selectedPaymentType,
      productsSales: this.selectedItems.map(item => ({
        productId: item.id,
        quantitySold: item.quantity
      }))
    };

    this.http.post<{ status: number; data: any }>('http://localhost:8080/sales/', saleData).subscribe({
      next: (result) => {
        alert((result as any).message);
        this.clearCart();
      },
      error: (error) => {
        alert(error.error.error);
      }
    });
  }

  clearCart(): void {
    this.selectedItems = [];
    this.hasItemsSelected = false;
    this.products.forEach(product => product.quantity = 0);
    this.calculateTotals();
  }

  setMatrixMaxHeight(toolbarHeight: number): void {
    const headerMarginBottom = 10;
    const pageOccupiedHeight = toolbarHeight + this.containerRef.nativeElement.offsetHeight + headerMarginBottom;
    this.matrixMaxHeight = `calc(100vh - ${pageOccupiedHeight}px)`;

    const registerHeaderHeight = 32;
    const matrixOccupiedHeight = pageOccupiedHeight + registerHeaderHeight;
    this.leftColumnHeight = `calc(100vh - ${matrixOccupiedHeight}px)`;

    this.cdr.detectChanges();
  }
}