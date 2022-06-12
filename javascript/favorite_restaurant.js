function attachFavoriteRestaurantEvents(){
    for(const button of document.querySelectorAll('.miniPreview > button')){
        button.addEventListener('click', async function (){
            const data = new FormData();
            data.append("restaurant", this.parentElement.dataset.id);
            data.append("add", this.classList.contains("checked") ? 0 : 1);
    
            const response = await fetch("../api/api_favorite_restaurants.php", {
                method: "POST",
                body : data,
            });
            
            if(response.status >= 200 && response.status < 300){
                this.classList.toggle("checked");
                this.classList.toggle("unchecked");
            }
                
        });
    }
}

attachFavoriteRestaurantEvents();