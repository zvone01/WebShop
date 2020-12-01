export class ProductVariant {
    ID: number;
    Name: string;
    ProductID: number;
    Price: number;
    ForNumPeople: number;


    constructor()
    {
        this.ID = -1;
        this.Name = "";
        this.ProductID = -1;
        this.ForNumPeople = -1;
        this.Price = -1;

    }
}