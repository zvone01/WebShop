/*
 * Home contact
 * Used in another component.
 */
import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';

@Component({
  selector: '[angly-homeContact]',
  templateUrl: './homeContact.component.html',
  styleUrls: ['./homeContact.component.scss']
})
export class HomeContactComponent implements OnInit {

   @Input() contact : any;

   constructor() { }

   ngOnInit() {
   }

}
