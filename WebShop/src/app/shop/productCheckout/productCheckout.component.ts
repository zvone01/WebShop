import { Component, OnInit } from '@angular/core';
import { MailService, AlertService } from '../../_services';

import { Router } from '@angular/router';
import { Cart } from '../../_models/cart';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ValidateDate } from '../../_helpers';
import { Calendar } from '../../_models';
import { CalendarService } from '../../_services';

@Component({
    selector: 'angly-product-checkout',
    templateUrl: './productCheckout.component.html',
    styleUrls: ['./productCheckout.component.scss']
})
export class ProductCheckoutComponent implements OnInit {
    mailForm: FormGroup;
    Cart: Cart[];
    TotalPrice: number;
    TotalCount: number;
    submitted = false;
    allDates: Calendar[] = [];
    minDate = new Date();

    constructor(
        private mailService: MailService,
        private formBuilder: FormBuilder,
        private router: Router,
        private alertService: AlertService,
        private calendarService: CalendarService) { }

    ngOnInit() {
        this.loadCart();

        this.mailForm = this.formBuilder.group({
            FirstName: ['', Validators.required],
            LastName: ['', Validators.required],
            CompanyName: [''],
            Email: ['', Validators.email],
            PhoneNumber: ['', Validators.required],
            Country: ['Switzerland', Validators.required],
            Address: ['', Validators.required],
            City: ['', Validators.required],
            PostalCode: ['', Validators.required],
            /*Date1: ['', [Validators.required, ValidateDate]],
            Date2: ['', [Validators.required, ValidateDate]],
            Date3: ['', [Validators.required, ValidateDate]],*/
            Exclusive: [false],
            Receipt: [false],
            R1Receipt: [false],
            AltSuggestions: [false],
            Note: ['']
        });
    }
    // convenience getter for easy access to form fields
    get f() { return this.mailForm.controls; }

    loadCart() {
        this.Cart = JSON.parse(localStorage.getItem('cart'));
        this.itemCountChange();
    }

    itemCountChange() {
        this.TotalPrice = 0;
        if (this.Cart != null) {
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

     /*   if (this.TotalPrice == 0) {
            this.router.navigate(['home']);
        }*/

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

    onSubmit() {

        var resCode = "";
        this.submitted = true;
        // stop here if form is invalid
        if (this.mailForm.invalid) {
            return;
        }

        if(localStorage.getItem('reservationCode'))
            resCode = localStorage.getItem('reservationCode');
            
        this.mailService.send(
            {
                "MailData": this.mailForm.value,
                "Cart": this.Cart,
                "ReservationDate": new Date(localStorage.getItem('reservationDate')).toJSON(),
                "ReservationDate1": new Date(localStorage.getItem('reservationDate1')).toJSON(),
                "ReservationDate2": new Date(localStorage.getItem('reservationDate2')).toJSON(),
                "ReservationDate3": new Date(localStorage.getItem('reservationDate3')).toJSON(),
                "PersonNum": localStorage.getItem('personNumber'),
                "reservationCode": resCode
            })
            .subscribe
            (message => {

                this.router.navigate(['thankyou']);
            },
            err => {
                //console.log(err)
                //this.router.navigate(['thankyou']);
            }
            );
        // this.router.navigate(['thankyou']);
    }

    goBack(){
        if(localStorage.getItem("selectionType") == "meal"){
            this.router.navigate(['/date']);
		} else{
			this.router.navigate(['/product-cart']);
		}
    }

}
