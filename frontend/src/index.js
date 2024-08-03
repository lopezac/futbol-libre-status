import React from "react";
import ReactDom from "react-dom/client";

import Home from "./pages/Home";

const root = ReactDom.createRoot(document.getElementById("root"));
root.render(
    <React.StrictMode>
        <Home />
    </React.StrictMode>
);