import { Component, OnInit } from '@angular/core';
import { Location } from '@angular/common';
import { PageTitleService } from '../core/page-title/page-title.service';
import { CategoryService, ProductService, CalendarService } from '../_services';
import { Category, Product, Cart, Calendar } from '../_models';
import { Router, ActivatedRoute } from '@angular/router';
import { environment } from '../../environments/environment';
import { forEach } from '../../../node_modules/@angular/router/src/utils/collection';

@Component({
  selector: 'app-step',
  templateUrl: './step.component.html',
  styleUrls: ['./step.component.css']
})
export class StepComponent implements OnInit {
  Categories: Category[];
  Products: Product[];
  selectedNumber: number;
  Cart: Cart[];
  CurrentCategoryText: string;
  CurrentDescriptionText: string;
  TotalPrice: number;
  Date: Date;
  PersonNumber: string;
  multiplyByPeopleNum: boolean = false;
  minDate = new Date();
  numArray = new Array();
  allDates: Calendar[] = [];
  maxDate = environment.maxDate;
  selectionType: string;
  //serverImgPath: string;

  constructor(
    private pageTitleService: PageTitleService,
    //private service: ChkService,
    private categoryService: CategoryService,
    private productService: ProductService,
    private router: Router,
    private route: ActivatedRoute,
    private location: Location,
    private calendarService: CalendarService
  ) {
    //this.HeaderText = "testtt";
  }

  ngOnInit() {
    this.loadAllCategories();
    this.fixMinDate();
    this.roundNext15Min();
    this.getAllDates();

    this.selectionType = localStorage.getItem("selectionType");

    for (var i = 8; i < 71; i++)
      this.numArray.push(i);
    this.selectedNumber = +this.route.snapshot.paramMap.get('Id');
    //this.HeaderText = this.currentHeader();
    this.getByCategoryOrdinalNumber(this.selectedNumber);
    this.loadCart();
    this.loadDate();
    this.loadPersonNumber();
  }

  currentCategoryText() {

    this.Categories.forEach(element => {
      if (element.OrdinalNumber == this.selectedNumber) {
        this.CurrentCategoryText = element.Name;
        this.CurrentDescriptionText = element.Description;
      }

    })


  }
  loadDate() {
    this.Date = new Date(localStorage.getItem('reservationDate'));
  }

  loadPersonNumber() {
    this.PersonNumber = localStorage.getItem('personNumber');
    if (localStorage.getItem('multiplyByPeopleNum'))
      this.multiplyByPeopleNum = true;
  }

  loadCart() {
    this.Cart = JSON.parse(localStorage.getItem('cart'));
    this.calculateTotal();
  }

  getImage(picture): string {
    return `${environment.apiUrl}` + "/img/p/" + picture;
  }

  roundNext15Min() {
    var intervals = Math.floor(this.minDate.getMinutes() / 15);
    if (this.minDate.getMinutes() % 15 != 0)
      intervals++;
    if (intervals == 4) {
      this.minDate.setHours(this.minDate.getHours() + 1);
      intervals = 0;
    }
    this.minDate.setMinutes(intervals * 15);
    return this;
  }

  fixMinDate() {
    if (this.minDate.getHours() < 18) {
      this.minDate.setHours(18);
      //this.minDate.setMinutes(30);
    }
  }

  private loadAllCategories() {

    if (localStorage.getItem('multiplyByPeopleNum'))
      this.loadMenus();
    else {
      this.categoryService.getAll()
        .subscribe(x => {
          this.Categories = x['Category'];
          //console.log(this.Categories);
          this.currentCategoryText();
        });
    }


  }

  private loadMenus() {
    this.categoryService.getMenu()
      .subscribe(x => {
        this.Categories = x['Category'];
        this.currentCategoryText();
      });


  }

  getAllDates() {
    this.calendarService.getAll().subscribe(x => { this.allDates = x });
  }

  public myFilter = (d: Date): boolean => {

    if (this.allDates.find(x => (new Date(x.Date).getDate() == d.getDate()
      && new Date(x.Date).getUTCMonth() == d.getUTCMonth()
      && new Date(x.Date).getUTCFullYear() == d.getUTCFullYear())) === undefined) {
      return true;
    }
    return false;
  }


  private getByCategoryOrdinalNumber(num: number) {
    this.productService.getByCategoryOrdinalNumber(num).subscribe(p => { this.Products = p['Product'] });
    this.selectedNumber = num;
  }

  private addToCart(product: Product) {
    let flag: boolean = false;

    let productLocalStorageArray: Cart[] = JSON.parse(localStorage.getItem('cart')) || [];

    productLocalStorageArray.forEach(element => {
      if (element.Product.ID == product.ID && element.Product.VariantID == product.VariantID) {
        if (this.multiplyByPeopleNum) {
          element.Count += Number(localStorage.getItem('personNumber'));
        } else {
          element.Count += 1;
        }

        flag = true;
      }
    });
    if (!flag) {
      let newCart: Cart;
      newCart = new Cart();
      newCart.Product = product;
      if (this.multiplyByPeopleNum) {
        newCart.Count = Number(localStorage.getItem('personNumber'));
      } else {
        newCart.Count = 1;
      }

      productLocalStorageArray.push(newCart);
    }

    if (!localStorage.getItem('cart')) {

      this.scroolToProductCart();
    }
    localStorage.setItem('cart', JSON.stringify(productLocalStorageArray));
    this.loadCart();
  }

  next() {

    if (this.selectedNumber < this.Categories.length) {
      this.selectedNumber = Number(this.selectedNumber) + 1;
      this.getByCategoryOrdinalNumber(this.selectedNumber);
      this.currentCategoryText();
      this.router.navigate(['/shop/' + this.selectedNumber]);
    }


  }


  back() {
    if (Number(this.selectedNumber) > 1) {
      this.selectedNumber--;// = Number(this.selectedNumber) -1;
      this.getByCategoryOrdinalNumber(this.selectedNumber);
      this.currentCategoryText();
      this.router.navigate(['/shop/' + this.selectedNumber]);
    }
  }

  start() {

    this.selectedNumber = 1;// = Number(this.selectedNumber) -1;
    this.getByCategoryOrdinalNumber(this.selectedNumber);
    this.currentCategoryText();
    this.router.navigate(['/shop/' + this.selectedNumber]);

  }

  calculateTotal() {
    this.TotalPrice = 0;
    if (this.Cart != null) {
      this.Cart.forEach(element => {
        if (element.Count > 0) {
          this.TotalPrice += (element.Count * (element.Product.VariantPrice == null ? element.Product.Price : element.Product.VariantPrice));
        }
      });

      //remove ones with count less then 1
      this.Cart = this.Cart.filter(c => c.Count > 0);

      //save to local storage
      localStorage.setItem('cart', JSON.stringify(this.Cart));
    }

  }
  removeItem(item: Product) {
    //remove ones with count less then 1
    this.Cart = this.Cart.filter(c => c.Product.ID != item.ID);

    //calculate total
    this.calculateTotal();

    //save to local storage
    localStorage.setItem('cart', JSON.stringify(this.Cart));
  }
  goBack() {
    this.location.back();
  }
  PersonNumberChagne(newPersonNumber) {

    localStorage.setItem('personNumber', newPersonNumber);
    this.PersonNumber = newPersonNumber;

  }

  DateChange() {
    if (this.checkTime()) {
      localStorage.setItem('reservationDate', this.Date.toLocaleString());
    } else {
      this.loadDate();
    }

  }

  checkTime() {
    if (this.Date.getHours() < 18) {
      return false;
    }
    return true;
  }


  multiplyByPeopleNumChanged() {
    //console.log(this.multiplyByPeopleNum);
  }

  scroolToProductCart(): void {
    try {

      document.querySelector('#product-cart-div').scrollIntoView({ behavior: "smooth" });
    } catch (e) { }
  }
}

