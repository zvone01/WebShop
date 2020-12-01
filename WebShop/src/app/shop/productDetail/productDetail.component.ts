import { Component, OnInit } from '@angular/core';
import { Location } from '@angular/common';
import { ProductService } from '../../_services';
import { Product, Cart } from '../../_models';
import { Router, ActivatedRoute } from '@angular/router';
import { environment } from '../../../environments/environment';

@Component({
	selector: 'angly-product-detail',
	templateUrl: './productDetail.component.html',
	styleUrls: ['./productDetail.component.scss']
})
export class ProductDetailComponent implements OnInit {
	product: Product;
	count: number;


	constructor(private productService: ProductService,
		private router: Router,
		private route: ActivatedRoute,
		private location: Location) {

		this.product = new Product;
		this.product.Name = "name";
		this.product.Description = "desc";
		this.product.Picture = "placeholder.png";
		this.product.Price = 1;

	}

	ngOnInit() {
		this.productService.getOneByIdWithVariants(Number(this.route.snapshot.paramMap.get('Id')),Number(this.route.snapshot.paramMap.get('variantId')))
			.subscribe(x => {
				this.product = x;
			});
	}

	goBack() {
		this.location.back();
	}

	addToCart() {
		let flag: boolean;
		flag = false;

		let productLocalStorageArray: Cart[] = JSON.parse(localStorage.getItem('cart')) || [];

		productLocalStorageArray.forEach(element => {
			if (element.Product.ID == this.product.ID) {
				element.Count += this.count;
				flag = true;
			}
		});
		if (!flag) {
			let newCart: Cart;
			newCart = new Cart();
			newCart.Product = this.product;
			newCart.Count = 1;
			productLocalStorageArray.push(newCart);
		}
		
		localStorage.setItem('cart', JSON.stringify(productLocalStorageArray));
		this.location.back();
	}

	getImage(picture): string {
		return `${environment.apiUrl}` + "/img/p/" + picture;
	}
}
