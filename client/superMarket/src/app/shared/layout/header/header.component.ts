import { CommonModule } from '@angular/common';
import { Component, EventEmitter, Input, Output } from '@angular/core';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';
import { Router } from '@angular/router';

@Component({
  selector: 'header',
  imports: [MatButtonModule, MatIconModule, CommonModule],
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent {
  @Input() title: string = 'SuperMarket';
  @Input() showCreateButton: boolean = false;
  @Input() isForm: boolean = false;
  @Input() buttonDisabled: boolean = false;
  @Output() buttonClicked = new EventEmitter();

  constructor(private router: Router) { }

  navigateToNew(): void {
    const currentUrl = this.router.url;
    this.router.navigate([currentUrl, 'new']);
  }
}
