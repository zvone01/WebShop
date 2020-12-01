import { Component, OnInit } from '@angular/core';
import { CalendarService, AlertService } from '../_services';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Calendar } from '../_models';

@Component({
  selector: 'app-admin-calendar',
  templateUrl: './admin-calendar.component.html',
  styleUrls: ['./admin-calendar.component.css']
})
export class AdminCalendarComponent implements OnInit {

  pickDateForm: FormGroup;
  pickDateForm2: FormGroup;
  submitteda:boolean = false;
  submittedr:boolean = false;
  disabledCalendar: boolean = true;
  allDates: Calendar[] = [];
  newDate: Date;
  minDate: Date = new Date();
  constructor(
    private calendarService: CalendarService,
    private formBuilder: FormBuilder,
    private alertService: AlertService) { }

  ngOnInit() {

    this.getAllDates();
    this.initForm();
    this.initForm2();
   
  }

  private initForm(){
    this.pickDateForm = this.formBuilder.group({
      Date: ['', Validators.required]
    });
    this.submitteda = false;
  }

  private initForm2(){
    this.pickDateForm2 = this.formBuilder.group({
      DateRemove: ['', Validators.required]
    });
    this.submittedr = false;
  }
  get f() { return this.pickDateForm.controls; }
  get f2() { return this.pickDateForm2.controls; }

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

  public myFilter2 = (d: Date): boolean => {

    if (this.allDates.find(x => (new Date(x.Date).getDate() == d.getDate()
      && new Date(x.Date).getUTCMonth() == d.getUTCMonth()
      && new Date(x.Date).getUTCFullYear() == d.getUTCFullYear())) === undefined) {
      return false;
    }
    return true;
  }

  onSubmitAdd() {
    this.submitteda = true;
    if (this.pickDateForm.invalid  ) {
			return;
		}
    var d = new Date(this.pickDateForm.value.Date);
    d.setHours(0, -d.getTimezoneOffset(), 0, 0);
    this.calendarService.create(d).subscribe(data => {
      this. getAllDates();
      this.alertService.success("date added");
      this.initForm();
    }, error => { this.alertService.error(error) });
  }

  onSubmitRemove() {
    this.submittedr = true;
    if (this.pickDateForm2.invalid  ) {
			return;
		}
    var d = new Date(this.pickDateForm2.value.DateRemove);
    d.setHours(0, -d.getTimezoneOffset(), 0, 0);
    var c = this.allDates.find(x => (new Date(x.Date).getDate() == d.getDate()
                                  && new Date(x.Date).getUTCMonth() == d.getUTCMonth()
                                  && new Date(x.Date).getUTCFullYear() == d.getUTCFullYear()));

    this.calendarService.delete(c.ID).subscribe(data => {
      this. getAllDates();
      this.alertService.success("date removed");
      this.initForm2();
    }, error => { this.alertService.error(error) });
  }

}

