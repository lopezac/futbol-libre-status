import Header from "../components/Header";
import Footer from "../components/Footer";

function ReloadPage() {
    async function handleSubmit(event) {
        event.preventDefault();

        // TODO: hacer este BACKEND_URL algo global
        const BACKEND_URL = process.env.REACT_APP_BACKEND_URL;
        let url = `${BACKEND_URL}/pages/update`;
        const keywordsInput = document.getElementById("keywords");

        try {
            if (keywordsInput) {
                url += `?keywords=${keywordsInput.value}`;
                const response = await fetch(url, {"method": "POST"});
                console.log(`Request to ${url} POST returned ${response.status}.`);

                if (response.ok && response.headers.get("Content-type") === "application/json") {
                    const data = await response.json();
                    console.log(data);
                }
            }
        } catch (error) {
            console.error(`An error ocurred doing request to ${url}`, error);
        }
    }

    return (
        <div className="d-flex flex-column main-div">
            <Header/>
            <main className="flex-grow-1 container-lg main-container my-5">
                <form action="" method="post" onSubmit={handleSubmit}>
                    <div>
                        <label htmlFor="keywords">Palabras claves</label>
                        <input type="text" minLength="6" maxLength="100" name="keywords" id="keywords"
                               placeholder="Futbol libre" required/>
                    </div>
                    <div>
                        <input type="submit" name="submitReload" value="Recargar"/>
                    </div>
                </form>
            </main>
            <Footer/>
        </div>
    );
}

export default ReloadPage;