import Header from "../components/Header";
import Footer from "../components/Footer";

function ReloadPage() {
    async function handleSubmit(event) {
        const url = "http://localhost:8000/index.php/pages";
        event.preventDefault();
        try {
            const response = await fetch(`${url}/update`, {"method": "POST"});
            if (response.ok) {
                const data = await response.json();
                console.log(data);
            }
        } catch (error) {
            console.error(`Error during request to ${url}.`, error);
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