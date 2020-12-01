import { Component, OnInit } from '@angular/core';
import { first } from 'rxjs/operators';
import { CategoryService, AlertService } from '../_services';
import { Category, } from '../_models';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { environment } from '../../environments/environment';



@Component({
  selector: 'app-category-view',
  templateUrl: './category-view.component.html',
  styleUrls: ['./category-view.component.css']
})
export class CategoryViewComponent implements OnInit {

  Categories: Category[];
  SelectedIDs: number[];
  selectedPicture: File;
  selectedPictureNew: File;
  currentID: number;
  placeholder: any;
  highestOrdinal: number;

  createCategoryForm: FormGroup;
  loading = false;
  submitted = false;

  constructor(
    private categoryService: CategoryService,
    private formBuilder: FormBuilder,
    private alertService: AlertService) {

    this.SelectedIDs = [];
    this.placeholder = environment.apiUrl + "/img/placeholder.png";

  }

  ngOnInit() {

    this.categoryService.readHighestOrdinal().pipe(first()).subscribe(
      x => {
        this.highestOrdinal = x + 1;
        this.createCategoryForm.controls['OrdinalNumber'].setValue(x + 1);
      });


    this.createCategoryForm = this.formBuilder.group({
      Name: ['', Validators.required],
      Description: ['', Validators.required],
      SubCategory: 0,
      OrdinalNumber: 1
      /*,
      Picture: ["placeholder.png"]*/
    });

    this.loadAllCategories();
    this.resetForm();

  }

  resetForm() {

    this.categoryService.readHighestOrdinal().pipe(first()).subscribe(
      x => {
        this.createCategoryForm = this.formBuilder.group({
          Name: ['', Validators.required],
          Description: ['', Validators.required],
          SubCategory: 0,
          OrdinalNumber: x + 1
        });
      });
  }

  private getHighestOrdinal() {
    let number
    return number;
  }

  onNgModelChange(event) {
    this.SelectedIDs.length = 0;
    for (let e of event) {
      this.SelectedIDs.push(e);
    }
  }

  private loadAllCategories() {
    this.categoryService.getAll()
      .subscribe(x => {
        this.Categories = x['Category'];
      });

  };

  onImageChanged(event, ID) {
    this.currentID = ID;
    this.selectedPicture = event.target.files[0];
    // this.onUpload(this.selectedPicture, this.currentID);
  }
  /*
    onImageChangedNew(fileInput) {
  
      this.selectedPictureNew = fileInput.target.files[0];
  
      let reader = new FileReader();
  
      reader.onload = (e: any) => {
        this.placeholder = e.target.result;
      }
  
      reader.readAsDataURL(fileInput.target.files[0]);
  
    }*/


  change(product) {
    this.categoryService.update(product)
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
    this.categoryService.delete(ID)
      .subscribe(
        data => {
          this.alertService.success(data["message"]);
          this.loadAllCategories();
          this.resetForm();
        },
        error => {
          this.alertService.error(error);
          this.loading = false;

        }
      );
  }

  /*
    getImage(picture): string {
      return  environment.apiUrl + "/img/c/" + picture;
    }*/
  /*
    onUpload(selectedFile, currentID) {
      this.categoryService.upload(selectedFile, currentID).pipe(first())
        .subscribe(
          data => {
            this.alertService.success(data["message"]);
            this.loadAllCategories();
          },
          error => {
            this.alertService.error(error);
            this.loading = false;
  
          }
  
        );
  
    }*/

up(ID: number){
  this.loading = true;

  this.categoryService.up(ID).subscribe(
    data => {
      //this.alertService.success(data["message"]);
      this.loadAllCategories();
      this.loading = false;
      //this.resetForm();
    },
    error => {
      this.alertService.error(error);
      this.loading = false;

    }
  );
}

down(ID: number){
  this.loading = true;

  this.categoryService.down(ID).subscribe(
    data => {
      //this.alertService.success(data["message"]);
      this.loadAllCategories();
      this.loading = false;
      //this.resetForm();
    },
    error => {
      this.alertService.error(error);
      this.loading = false;

    }
  );
}
  onSubmit() {
    this.submitted = true;
    if (this.createCategoryForm.invalid) {
      this.alertService.warn("Form error");
      return;
    }

    this.loading = true;
    this.categoryService.create(this.createCategoryForm.value)
      .pipe(first())
      .subscribe(

        data => {
          this.alertService.success(data["message"]);
          this.resetForm();
          this.loadAllCategories();
          /* if (this.placeholder != environment.apiUrl + "/img/placeholder.png") {
             this.categoryService.uploadImage(this.selectedPictureNew).pipe(first())
               .subscribe(
 
                 () => {
 
                   this.loadAllCategories();
                   this.createCategoryForm.reset();
                   this.resetForm();
                   this.placeholder = environment.apiUrl + "/img/placeholder.png";
                 }
 
               )
           }
           else {
             this.loadAllCategories();
             this.createCategoryForm.reset();
             this.resetForm();
             this.placeholder = environment.apiUrl + "/img/placeholder.png";
           };*/
        },
        error => {
          this.alertService.error(error);
          this.loading = false;

        });

  }

}
