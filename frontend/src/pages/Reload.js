import Header from "../components/Header";
import Footer from "../components/Footer";

function ReloadPage() {
    async function handleSubmit(event) {
        event.preventDefault();

        const url = `${process.env.REACT_APP_BACKEND_URL}/pages/update`;
        try {
            const response = await fetch(url, {"method": "POST"});
            if (response.ok) {
                const data = await response.json();
                console.log(`Response from ${url}/update POST`, data);
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