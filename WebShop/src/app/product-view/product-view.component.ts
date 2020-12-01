import { Component, OnInit } from '@angular/core';
import { first } from 'rxjs/operators';
import { Product, Category } from '../_models';
import { ProductService, CategoryService, AlertService, ProductVariantService } from '../_services';

import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { environment } from '../../environments/environment';
import { element } from '../../../node_modules/protractor';

@Component({
  selector: 'app-product-view',
  templateUrl: './product-view.component.html',
  styleUrls: ['./product-view.component.css'],
})


export class ProductViewComponent implements OnInit {

  Products: Product[];
  Categories: Category[];
  CategoriesFiltered: Map<Number, Number>;
  CategoriesCount: Map<Number, Number>;
  selectedPicture: File;
  selectedPictureNew: File;
  currentID: Number;
  placeholder: any;

  createProductForm: FormGroup;
  loading = false;
  submitted = false;

  constructor(private productService: ProductService,
    private categoryService: CategoryService,
    private ProductVariantService: ProductVariantService,
    private formBuilder: FormBuilder,
    private alertService: AlertService
  ) {

    this.placeholder = environment.apiUrl + "/img/p/" + "placeholder.png";
    this.CategoriesFiltered = new Map;
  }

  ngOnInit() {
    this.loadAllProducts();
    this.loadAllCategories();

    this.resetForm();
  }

  resetForm() {
    this.createProductForm = this.formBuilder.group({
      Name: ['', Validators.required],
      Description: ['', Validators.required],
      Price: [0, Validators.required],
      Picture: ["placeholder.png"],
      CategoryId: [1]
    });
  }

  onImageChanged(event, ID) {
    this.currentID = ID;
    //console.log("onImageChanged");
    this.selectedPicture = event.target.files[0];
    this.onUpload(this.selectedPicture, this.currentID);
  }

  onImageChangedNew(fileInput) {

    this.selectedPictureNew = fileInput.target.files[0];

    let reader = new FileReader();

    reader.onload = (e: any) => {
      this.placeholder = e.target.result;
    }
    reader.readAsDataURL(fileInput.target.files[0]);
  }

  get f() { return this.createProductForm.controls; }

  onUpload(selectedFile, currentID) {
   // console.log("onUpload");
    this.productService.upload(selectedFile, currentID).pipe(first())
      .subscribe(
        data => {
          this.alertService.success(data["message"]);
          this.loadAllProducts();
        },
        error => {
          this.alertService.error(error);
          this.loading = false;
        }
      );

  }

  private loadAllProducts() {
    this.productService.getAll()
      .subscribe(x => {
        this.Products = x['Product'];
        this.filterProductsInit()
      });
  };

  private loadAllCategories() {
    this.categoryService.getAll()
      .subscribe(x => {
        this.Categories = x['Category'];
        this.filterInit();
      });

  };

  filterInit()
{
  this.Categories.forEach(element =>
    {
      this.CategoriesFiltered.set(element.ID, 1);
            
    })

//console.log(this.CategoriesFiltered);
}

filterProductsInit()
{
  this.Products.forEach(element =>
    {
      element.OriginalCategoryID = element.CategoryId;
            
    })


}

filterAll()
{
  this.Categories.forEach(element =>
    {
      this.CategoriesFiltered.set(element.ID, 1);
            
    })

//console.log(this.CategoriesFiltered);
}

filterNone()
{

  this.Categories.forEach(element =>
    {
    
      this.CategoriesFiltered.set(element.ID, 0);
            
    })


  //console.log(this.CategoriesFiltered);
}

filterID(ID)
{

  if(this.CategoriesFiltered.get(ID) == 0)
  {
    this.CategoriesFiltered.set(ID, 1);
  }
  else
  {
    this.CategoriesFiltered.set(ID, 0);
  }


//console.log(this.CategoriesFiltered);
}

filtered(ID)
{
 if(this.CategoriesFiltered.get(ID) == 0)
 {
  return 0;
 }
  return 1;
}

  getImage(picture): string {
    return environment.apiUrl + "/img/p/" + picture;
  }


  up(ID: number, CategoryId: number){
    this.loading = true;
  
    this.productService.up(ID, CategoryId).subscribe(
      data => {
        //this.alertService.success(data["message"]);
        this.loadAllProducts();
        this.loading = false;
        //this.resetForm();
      },
      error => {
        this.alertService.error(error);
        this.loading = false;
  
      }
    );
  }
  
  down(ID: number, CategoryId: number){
    this.loading = true;
  
    this.productService.down(ID, CategoryId).subscribe(
      data => {
        //this.alertService.success(data["message"]);
        this.loadAllProducts();
        this.loading = false;
        //this.resetForm();
      },
      error => {
        this.alertService.error(error);
        this.loading = false;
  
      }
    );
  }



  change(product) {
    //console.log(product);
    this.productService.update(product)
      .subscribe(

        data => {

          this.ProductVariantService.updateDefault(product).subscribe
            (
            data => {
              this.alertService.success(data["message"]);
              this.loadAllProducts();
            },
            error => {
              this.alertService.error(error);
              this.loading = false;
            }


            )

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
          this.loadAllProducts();
        
        },
        error => {
          this.alertService.error(error);
          this.loading = false;

        }
      );
  }

  deletePicture(id) {

    this.productService.deletePicture(id)
      .subscribe(
        data => {
          this.alertService.success(data["message"]);
          this.loadAllProducts();
         
        },
        error => {
          this.alertService.error(error);
          this.loading = false;

        }
      );
  }

  deletePictureNew() {
    this.placeholder = environment.apiUrl + "/img/p/placeholder.png";
  }


  onSubmit() {
    this.submitted = true;
    if (this.createProductForm.invalid) {
      this.alertService.warn("Form error");
      return;
    }
    this.loading = true;
    this.productService.create(this.createProductForm.value)
      .pipe(first())
      .subscribe(

        data => {
          this.alertService.success(data["message"]);
          this.loadAllProducts();
          if (this.placeholder != environment.apiUrl + "/img/p/placeholder.png") {
            this.productService.uploadImage(this.selectedPictureNew).pipe(first())
              .subscribe(
                () => {
                  this.loadAllProducts();
                 
                  this.createProductForm.reset();
                  this.resetForm();
                  this.placeholder = environment.apiUrl + "/img/p/placeholder.png";
                }

              )
          }
          else {
            this.loadAllProducts();
          
            this.createProductForm.reset();
            this.resetForm();
            this.placeholder = environment.apiUrl + "/img/p/placeholder.png";
          };

        },
        error => {
          this.alertService.error(error);
          this.loading = false;

        });

  }

}
