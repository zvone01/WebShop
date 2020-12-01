import { Product } from "./product";

export class Menu {
    Name: string;
    ID: number;
    Description: string;
    Products: Product[];

    constructor(){
        this.Name = "";
        this.Description = "";
        this.ID = -1;
        this.Products = [];
    }
}