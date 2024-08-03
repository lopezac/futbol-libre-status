import { Link } from 'react-router-dom';

function Header() {
    return (
        <nav className="border-bottom p-4 shadow">
            <ul className="list-inline m-0 fs-5">
                <li className="list-inline-item">
                    <Link to="/" className="text-decoration-none text-reset">Futbol Libre Status</Link>
                </li>
                <li className="list-inline-item float-end">
                    <Link to="/reload" className="text-decoration-none text-reset">Reload</Link>
                </li>
            </ul>
        </nav>
    );
}

export default Header;