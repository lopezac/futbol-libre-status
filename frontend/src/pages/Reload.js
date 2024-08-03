import Header from "../components/Header";
import Footer from "../components/Footer";

function ReloadPage() {
    return (
        <div className="d-flex flex-column main-div">
            <Header/>
            <main className="flex-grow-1 container-lg main-container my-5">
                <form action="" method="post">
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