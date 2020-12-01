export class Product {
    ID: number;
    Name: string;
    Description: string;
    Price: number;
    CategoryId: number;
    OriginalCategoryID: number;
    OrdinalNumber: number;
    CategoryName: string;
    Picture: string;
    VariantPrice: number;
    VariantID: number;
    VariantName: string;
    ForNumPeople: number;

    constructor()
    {
        this.ID = -1;
        this.Name = "";
        this.Description = "";
        this.Picture = "placeholder.png";
        this.CategoryName = "";

    }
}