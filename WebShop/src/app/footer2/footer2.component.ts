import { Component, Inject, OnInit, HostListener } from '@angular/core';
import { MenuItems } from '../core/menu/menu-items/menu-items';
import { Router } from '@angular/router';
import { DOCUMENT } from '@angular/platform-browser';
declare var $ : any;

@Component({
  selector: '[angly-footer2]',
  templateUrl: './footer2.component.html',
  styleUrls: ['./footer2.component.scss']
})
export class Footer2Component implements OnInit {

   /* Variables */
   footer2Menu : any;
   footerLogo  : any;

   constructor(public menuItems: MenuItems, @Inject(DOCUMENT) private document: Document, public router: Router) { }

   ngOnInit() {

      this.footer2Menu = this.menuItems.getFooter2();
      window.addEventListener('scroll', this.scroll, true);
      $("#back-top").hide();
   }

   scroll() {
    if (this.document.body.scrollTop > 300){
        $('#back-top').fadeIn(0);
    } else {
        $('#back-top').fadeOut(0);
    }
  }


  topScroll(e)
  {
    e.preventDefault();
            $('body,html').animate({
                scrollTop: 0
            }, 1000);
            return false;
  }

   subscribeFormClasses : any = {rowClass:"row", fieldClass:"col-sm-12 col-md-6"}

}
