import { Component, OnInit, HostListener, Inject, } from '@angular/core';
import { MenuItems } from '../core/menu/menu-items/menu-items';
import { Router } from '@angular/router';
import { AlertService, AuthenticationService, UserService } from '../_services';
declare var $: any;

@Component({
  selector: '[angly-menu]',
  templateUrl: './menu.component.html',
  styleUrls: ['./menu.component.scss']
})
export class MenuComponent implements OnInit {

  searchactive: boolean = false;

  constructor(
    public menuItems: MenuItems,
    private authenticationService: AuthenticationService,
    public router: Router) { }

  ngOnInit() { }

  searchActiveFunction() {
    this.searchactive = !this.searchactive;
  }

  onClickOutside(event: Object) {
    if (event && event['value'] === true) {
      this.searchactive = false;
    }
  }

  public removeCollapseInClass() {
    $("#navbarCollapse").removeClass('show');
  }


  logout() {

    this.authenticationService.logout();
    this.router.navigate(["/login"]);

  }

}
