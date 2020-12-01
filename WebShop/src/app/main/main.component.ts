import { Component, OnInit,  HostListener,  } from '@angular/core';

declare var $: any;

@Component({
	selector: 'angly-layout',
	templateUrl: './main.component.html',
	styleUrls: ['./main.component.scss']
})
export class MainComponent implements OnInit {

	fixedHeaderClass: boolean = false;

	constructor() { }
  
	ngOnInit() {
	}
 
	@HostListener('scroll', ['$event'])
	onScroll(event) {
		var path = event.path || (event.composedPath && event.composedPath());
		if (path) {

			if (path[0].scrollTop > 0) {
				this.fixedHeaderClass = true;
			} else {
				this.fixedHeaderClass = false;
			}
		} else {

		}
	}

	onActivate(e, scrollContainer) {
		scrollContainer.scrollTop = 0;
	}

}
