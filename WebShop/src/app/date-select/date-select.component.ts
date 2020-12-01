import { Component, OnInit } from '@angular/core';
declare var $: any;
import { Router } from '@angular/router';
import { FormBuilder } from '@angular/forms';
import { FormGroup } from '@angular/forms';
import { Validators } from '@angular/forms';
import { ValidateDate } from '../_helpers';
import { Calendar } from '../_models';
import { CalendarService } from '../_services';
import { environment } from '../../environments/environment';

@Component({
  selector: 'app-date-select',
  //templateUrl: './date-select.component.html',
  templateUrl: './date-select_test.component.html',
  styleUrls: ['./date-select.component.css']
})
export class DateSelectComponent  implements OnInit {

	pickDateForm: FormGroup;
	submitted = false;
	minDate = new Date();
	maxDate = environment.maxDate;
	numArray = new Array();
	allDates: Calendar[] = [];
	minPersonNum: number;
	selectionType: string;
	constructor(
		private calendarService: CalendarService,
		private formBuilder: FormBuilder,
		private router: Router) {
		this.minPersonNum = 8;
	}

	ngOnInit() {
		//console.log(environment.maxDate)
		this.fixMinDate();
		this.roundNext15Min();
		this.getAllDates();

		this.selectionType = localStorage.getItem("selectionType");
		for (var i = this.minPersonNum; i < 71; i++)
			this.numArray.push(i);

		this.pickDateForm = this.formBuilder.group({
			Date: [this.minDate, [Validators.required, ValidateDate]],
			Date1: ['', [ValidateDate]],
			Date2: ['', [ValidateDate]],
			Date3: ['', [ValidateDate]],
			PersonNum: [this.minPersonNum, Validators.required]
		});
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

	fixMinDate(){
		if(this.minDate.getHours() < 18){
			this.minDate.setHours(18);
			//this.minDate.setMinutes(30);
		}
	}

	checkTime(){
		var ret = true;
		if(this.pickDateForm.value.Date.getHours() < 18  /*|| (this.pickDateForm.value.Date.getHours() == 17  && this.pickDateForm.value.Date.getMinutes() < 30 )*/){
			this.pickDateForm.controls['Date'].setErrors({'validTime': true});
			ret = false;
		}
		if(this.pickDateForm.value.Date1 && this.pickDateForm.value.Date1.getHours() < 18 ){
			this.pickDateForm.controls['Date1'].setErrors({'validTime': true});
			ret = false;
		}
		if(this.pickDateForm.value.Date2 && this.pickDateForm.value.Date2.getHours() < 18 ){
			this.pickDateForm.controls['Date2'].setErrors({'validTime': true});
			ret = false;
		}
		if(this.pickDateForm.value.Date3  && this.pickDateForm.value.Date3.getHours() < 18 ){
			this.pickDateForm.controls['Date3'].setErrors({'validTime': true});
			ret = false;
		}
		return ret;
	}


	// convenience getter for easy access to form fields
	get f() { return this.pickDateForm.controls; }

	onSubmit() {
		this.submitted = true;
		localStorage.removeItem('cart');
		// stop here if form is invalid
		if (this.pickDateForm.invalid || !this.checkTime()) {
			return;
		}
		localStorage.setItem('personNumber', this.pickDateForm.value.PersonNum);
		localStorage.setItem('reservationDate', this.pickDateForm.value.Date);
		localStorage.setItem('reservationDate1', this.pickDateForm.value.Date1);
		localStorage.setItem('reservationDate2', this.pickDateForm.value.Date2);
		localStorage.setItem('reservationDate3', this.pickDateForm.value.Date3);

		if(localStorage.getItem("selectionType") == "dateAndMeal"){
			this.router.navigate(['/page3']);
		} else{
			this.router.navigate(['/product-checkout']);
		}
		
	}

	getAllDates() {
		this.calendarService.getAll().subscribe(x => { this.allDates = x;});
	}

	public myFilter = (d: Date): boolean => {
		
		if (this.allDates.find(x => (new Date(x.Date).getDate() == d.getDate()
			&& new Date(x.Date).getUTCMonth() == d.getUTCMonth()
			&& new Date(x.Date).getUTCFullYear() == d.getUTCFullYear())) === undefined) {

			return true;
		}

		return false;
	}

	goBack(){
            this.router.navigate(['/home']);
    }

}
