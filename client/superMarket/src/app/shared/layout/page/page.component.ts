import { CommonModule } from '@angular/common';
import { AfterViewInit, Component, ElementRef, EventEmitter, Output, ViewChild } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatIconModule } from '@angular/material/icon';
import { MatInputModule } from '@angular/material/input';
import { MatListModule } from '@angular/material/list';
import { MatSidenavModule } from '@angular/material/sidenav';
import { MatToolbarModule } from '@angular/material/toolbar';
import { Router } from '@angular/router';

@Component({
  selector: 'page',
  standalone: true,
  imports: [
    FormsModule,
    CommonModule,
    MatToolbarModule,
    MatIconModule,
    MatButtonModule,
    MatInputModule,
    MatFormFieldModule,
    MatSidenavModule,
    MatListModule
  ],
  templateUrl: './page.component.html',
  styleUrls: ['./page.component.scss']
})
export class PageComponent implements AfterViewInit {
  @ViewChild('toolbarContainer') containerRef!: ElementRef;
  @ViewChild('pageContainer') pageContainerRef!: ElementRef;
  @Output() pageLoaded = new EventEmitter<number>();

  constructor(private router: Router) { }

  ngAfterViewInit(): void {
    const pageContainer = this.pageContainerRef.nativeElement;
    const toolbarHeight = this.calculateToolbarHeight();
    pageContainer.style.height = `calc(100vh - ${toolbarHeight}px)`;
    this.pageLoaded.emit(toolbarHeight);
  }

  calculateToolbarHeight(): number {
    return this.containerRef.nativeElement.offsetHeight;
  }

  navigateTo(route: string): void {
    this.router.navigate([route]);
  }
}