import {useEffect, useState} from "react";

// TODO: hacer url dinamica en vez de ../components
import Header from "../components/Header";
import Footer from "../components/Footer";
import {SuccessIcon} from "../components/Icons";
import "../styles.css";

function HomePage() {
    const [pages, setPages] = useState([]);

    useEffect(() => {
        async function fetchData() {
            const url = `${process.env.REACT_APP_BACKEND_URL}/pages`;
            console.log(`Url = ${url}`);

            try {
                const response = await fetch(url, {"method": "GET"});
                const data = await response.json();
                console.log(`Request to ${url} GET returned ${response.status}.`, data);
                if (response.ok) {
                    setPages(data["pages"]);
                }
            } catch (error) {
                console.error(`An error ocurred doing request to ${url}`, error);
            }
        }

        fetchData();
    }, []);

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
                        {pages.length ? (
                            <tbody>
                            {pages.map((page, index) => (
                                <tr key={index} className="border-top border-secondary-subtle">
                                    <td className="py-1 px-0 fw-medium fs-4 text-center border-end"
                                        style={{"width": "70px"}}>
                                        <SuccessIcon/>
                                    </td>
                                    <td className="py-1 px-2 fw-medium fs-4 align-middle">
                                        <a className="flex-grow-1 text-decoration-none"
                                           href={page["url"]}>{page["url"]}</a>
                                    </td>
                                </tr>
                            ))}
                            </tbody>
                        ) : ""}
                    </table>
                </div>
            </main>
            <Footer/>
        </div>
    );
}

export default HomePage;