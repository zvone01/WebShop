import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router'
import { Cart } from '../../_models';
import { Location } from '@angular/common';
import { environment } from '../../../environments/environment';

@Component({
	selector: 'angly-product-cart',
	templateUrl: './productCart.component.html',
	styleUrls: ['./productCart.component.scss']
})
export class ProductCartComponent implements OnInit {

	/* Variables */
	Cart: Cart[];
	TotalPrice: number;
	TotalCount: number;

	constructor(private location: Location, private router: Router) {
		this.TotalPrice = 0;
		this.TotalCount = 0;

	}

	ngOnInit() {

		this.loadCart();
		this.itemCountChange();
	}

	loadCart() {
		this.Cart = JSON.parse(localStorage.getItem('cart'));
	}


	itemCountChange() {
		this.TotalPrice = 0;
		if(this.Cart != null){
			this.Cart.forEach(element => {
				if (element.Count > 0) {
					this.TotalPrice += (element.Count * element.Product.VariantPrice);
					this.TotalCount += element.Count;
				}
			});
	
			//remove ones with count less then 1
			this.Cart = this.Cart.filter(c => c.Count > 0);
	
			//save to local storage
			localStorage.setItem('cart', JSON.stringify(this.Cart));
		}
		
	}

	getImage(picture): string {
		return `${environment.apiUrl}` + "/img/p/" + picture;
	}

	removeItem(itemID: number) {
		//remove ones with count less then 1
		this.Cart = this.Cart.filter(c => c.Product.ID != itemID);

		//save to local storage
		localStorage.setItem('cart', JSON.stringify(this.Cart));
		this.itemCountChange();

	}

	goBack() {
		
		this.router.navigate(['shop/1']);

	}

}
