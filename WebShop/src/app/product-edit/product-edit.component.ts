import { Component, OnInit } from '@angular/core';

import { first } from 'rxjs/operators';
import { Product, Category, ProductVariant } from '../_models';

import { ProductService, CategoryService, AlertService, ProductVariantService  } from '../_services';

import { FormBuilder, FormGroup, Validators } from '@angular/forms';

import { Router, ActivatedRoute } from '@angular/router';
import { environment } from '../../environments/environment';

@Component({
  selector: 'app-product-edit',
  templateUrl: './product-edit.component.html',
  styleUrls: ['./product-edit.component.css']
})
export class ProductEditComponent implements OnInit {

  Product: Product;
  ProductVariants: ProductVariant[];
  Categories: Category[];
  
  loading = false;
  submitted = false;
  
  createProductForm: FormGroup;

  constructor(private productService: ProductService,
    private productVariantService: ProductVariantService,
    private categoryService: CategoryService, 
    private route: ActivatedRoute,  
    private router: Router,
    private formBuilder: FormBuilder,
    private alertService: AlertService)
  {
    this.Product = new Product;
  }

  ngOnInit() {
    this.loadProduct();
    this.loadProductVariants();
    this.loadAllCategories();

    this.resetForm();
  }

  resetForm() {
    this.createProductForm = this.formBuilder.group({
      Name: ['', Validators.required],
      ForNumPeople: [1, Validators.required],
      ProductID: [Number(this.route.snapshot.paramMap.get('Id'))],
      Price: [1]
    });
  }


  private loadProduct() {
    this.productService.getOne(Number(this.route.snapshot.paramMap.get('Id')))
      .subscribe(x => {
        this.Product = x;
      });
  };

  private loadProductVariants() {
    this.productVariantService.getByProductID(Number(this.route.snapshot.paramMap.get('Id')))
      .subscribe(x => {
        this.ProductVariants = x['productVariant'];
      });
  };

  
  private loadAllCategories() {
    this.categoryService.getAll()
      .subscribe(x => {
        this.Categories = x['Category'];
      });

  };


  getImage(picture): string {
    return  environment.apiUrl + "/img/p/" + picture;
  }

  
  change(product) {
    this.productService.update(product)
      .subscribe(

        data => {
          this.alertService.success(data["message"]);

        },
        error => {
          this.alertService.error(error);
          this.loading = false;

        });
  }

  changeVariant(ProductVariant) {
    this.productVariantService.update(ProductVariant)
      .subscribe(

        data => {
          this.alertService.success(data["message"]);

        },
        error => {
          this.alertService.error(error);
          this.loading = false;

        });
  }

  
  delete(ID) {
    this.productService.delete(ID)
      .subscribe(
        data => {
          this.alertService.success(data["message"]);
          this.router.navigate(['/product-view']);
        },
        error => {
          this.alertService.error(error);
          this.loading = false;

        }
      );
  }

  deleteVariant(ID) {
    this.productVariantService.delete(ID)
      .subscribe(
        data => {
          this.alertService.success(data["message"]);
          this.loadProductVariants();
        },
        error => {
          this.alertService.error(error);
          this.loading = false;

        }
      );
  }

  onSubmit() {
    this.submitted = true;
    if (this.createProductForm.invalid) {
      this.alertService.warn("Form error");
      return;
    }


    this.loading = true;

    this.productService.createVariant(this.createProductForm.value)
      .pipe(first())
      .subscribe(

        data => {
          this.alertService.success(data["message"]);

          this.loadProductVariants();

        },
        error => {
          this.alertService.error(error);
          this.loading = false;

        });

  }

  
  deletePicture(id) {

    this.productService.deletePicture(id)
      .subscribe(
        data => {
          this.alertService.success(data["message"]);
         // this.loadAllProducts();
        },
        error => {
          this.alertService.error(error);
          this.loading = false;

        }
      );
  }

  
  onImageChanged(event, ID) {
  }

}
