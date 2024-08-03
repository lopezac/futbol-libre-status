import { GithubIcon, EmailIcon } from "./Icons";

function Footer() {
    return (
        <footer className="d-flex align-items-center justify-content-center gap-3 border-top p-1">
            <ul className="list-inline m-0 d-flex justify-content-center">
                <li className="list-inline-item">
                    <a className="text-reset text-decoration-none" href="https://www.github.com/lopezac"><GithubIcon/></a>
                </li>
                <li className="list-inline-item">
                    <a className="text-reset text-decoration-none" href="mailto:aclopez@fi.uba.ar"><EmailIcon/></a>
                </li>
            </ul>
            <p className="m-0 text-center fs-5 fw-light">Axel Carlos Lopez @Copyright 2024</p>
        </footer>
    );
}

export default Footer;