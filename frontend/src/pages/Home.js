import Header from "../components/Header";
import Footer from "../components/Footer";
import {AlertIcon, SuccessIcon} from "../components/Icons";
import "../styles.css";

function Home() {
    const pages = [
        {"status": 0, "url": "https://www.pelotalibre.com"},
        {"status": 1, "url": "https://www.futbollibre.com"},
        {"status": 1, "url": "https://www.pelotalibre.television.com"},
        {"status": 0, "url": "https://www.futbollibre.net"},
    ];

    return (
        <div className="d-flex flex-column main-div">
            <Header/>
            <main className="flex-grow-1 container-lg main-container my-5">
                <div className="text-center mb-4">
                    <h1 className="fs-3 fw-bold">Futbol Libre Status</h1>
                    <p className="fw-light fs-5">Lista de paginas de Futbol Libre y clones, que funcionan
                        actualmente</p>
                </div>
                <div className="shadow">
                    <div className="text-light py-3 border border-secondary-subtle"
                         style={{"backgroundColor": "#188735"}}>
                        <p className="text-center fs-5 m-0">Actualizado al 3 de agosto del 2024</p>
                    </div>
                    <table className="table border border-top-0 border-secondary-subtle table-striped">
                        <thead>
                        <tr>
                            <th className="py-2 px-2 fw-normal fs-4 text-center border-end"
                                style={{"width": "70px", "backgroundColor": "#cccccc"}}>Status
                            </th>
                            <th className="py-2 px-2 fw-normal fs-4 align-middle"
                                style={{"backgroundColor": "#cccccc"}}>URL
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        {pages.map((page, index) => (
                            <tr key={index} className="border-top border-secondary-subtle">
                                <td className="py-1 px-0 fw-medium fs-4 text-center border-end"
                                    style={{"width": "70px"}}>
                                    {page["status"] === 1 ? <AlertIcon/> : <SuccessIcon/>}
                                </td>
                                <td className="py-1 px-2 fw-medium fs-4 align-middle">
                                    <a className="flex-grow-1 text-decoration-none" href={page["url"]}>{page["url"]}</a>
                                </td>
                            </tr>
                        ))}
                        </tbody>
                    </table>
                </div>
            </main>
            <Footer/>
        </div>
    );
}

export default Home;