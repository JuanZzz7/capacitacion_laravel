# Diagrama de Casos de Uso - Spotlight
Plataforma Web para Micro, Pequeñas e Informales Empresas

Este documento contiene el diagrama UML de casos de uso para **Spotlight**, optimizado para que **GitHub** lo renderice de forma nativa e interactiva mediante **Mermaid**.

---

## 1. Diagrama de Casos de Uso (Mermaid)

> **Nota para GitHub**: GitHub interpreta automáticamente el bloque ````mermaid```` que se muestra a continuación:

```mermaid
flowchart LR
    %% Actores Principales
    subgraph ACTORES ["Actores"]
        A_Micro["👤 Microempresario / Emprendedor<br/>(Dueño de Negocio)"]:::actorStyle
        A_Cliente["👥 Cliente / Comprador"]:::actorStyle
        A_Admin["🛡️ Administrador del Sistema"]:::actorStyle
        A_Msg["📱 WhatsApp / Billeteras Digitales<br/>(Sistema Externo)"]:::extActorStyle
    end

    %% Límite del Sistema
    subgraph SYSTEM [" Sistema Web Spotlight (Micro, Pequeñas e Informales Empresas) "]
        direction TB

        %% Módulo 1: Registro y Configuración
        subgraph MOD_CONFIG ["1. Onboarding y Configuración Ligera"]
            UC_RegNegocio(["Registrar Microempresa / Perfil"]):::ucStyle
            UC_ConfigPagos(["Configurar Métodos de Cobro<br/>(Efectivo, Nequi/Daviplata, Transferencia)"]):::ucStyle
            UC_Autenticar(["Iniciar Sesión / Recuperar Acceso"]):::ucStyle
        end

        %% Módulo 2: Catálogo y Productos
        subgraph MOD_CATALOGO ["2. Gestión de Catálogo e Inventario"]
            UC_GestProd(["Gestionar Productos / Servicios"]):::ucStyle
            UC_FotosPrecios(["Cargar Fotos y Precios"]):::ucStyle
            UC_Stock(["Controlar Stock Básico"]):::ucStyle
            UC_Compartir(["Compartir Catálogo Digital<br/>(Enlace a WhatsApp y Redes)"]):::ucStyle
        end

        %% Módulo 3: Vitrina Digital y Pedidos
        subgraph MOD_VITRINA ["3. Vitrina Digital y Pedidos (Cliente)"]
            UC_VerCatalogo(["Explorar Vitrina Digital"]):::ucStyle
            UC_BuscarProd(["Buscar y Filtrar Productos"]):::ucStyle
            UC_Carrito(["Armar Lista de Compra / Carrito"]):::ucStyle
            UC_EnviarPedido(["Enviar Pedido Directo (WhatsApp / Web)"]):::ucStyle
            UC_AcordarEntrega(["Acordar Método de Entrega o Retiro"]):::ucStyle
        end

        %% Módulo 4: Ventas y Libro de Fiado
        subgraph MOD_VENTAS ["4. Operaciones Diarias y Libro de Fiado"]
            UC_VentaRapida(["Registrar Venta Rápida (Mostrador)"]):::ucStyle
            UC_LibroFiado(["Gestionar Libro de Fiado<br/>(Cuentas por Cobrar)"]):::ucStyle
            UC_RegistrarAbono(["Registrar Abonos a Deudas"]):::ucStyle
        end

        %% Módulo 5: Finanzas Sencillas
        subgraph MOD_REPORTES ["5. Finanzas y Métricas Simples"]
            UC_ReporteDiario(["Consultar Balance Diario<br/>(Ingresos y Gastos)"]):::ucStyle
            UC_Metricas(["Visualizar Productos Más Vendidos"]):::ucStyle
        end

        %% Módulo 6: Administración
        subgraph MOD_ADMIN ["6. Administración de Plataforma"]
            UC_AdminNegocios(["Supervisar Cuentas de Negocios"]):::ucStyle
            UC_Soporte(["Soporte Técnico y Mantenimiento"]):::ucStyle
        end
    end

    %% Relaciones de Microempresario
    A_Micro --- UC_RegNegocio
    A_Micro --- UC_ConfigPagos
    A_Micro --- UC_Autenticar
    A_Micro --- UC_GestProd
    A_Micro --- UC_Compartir
    A_Micro --- UC_VentaRapida
    A_Micro --- UC_LibroFiado
    A_Micro --- UC_RegistrarAbono
    A_Micro --- UC_ReporteDiario
    A_Micro --- UC_Metricas

    %% Relaciones de Cliente
    A_Cliente --- UC_VerCatalogo
    A_Cliente --- UC_BuscarProd
    A_Cliente --- UC_Carrito
    A_Cliente --- UC_EnviarPedido
    A_Cliente --- UC_AcordarEntrega

    %% Relaciones de Administrador
    A_Admin --- UC_AdminNegocios
    A_Admin --- UC_Soporte

    %% Interacciones Externas
    UC_EnviarPedido -.->|Notifica pedido vía| A_Msg
    UC_Compartir -.->|Genera enlace para| A_Msg

    %% Relaciones Include y Extend (UML)
    UC_GestProd -.->|&lt;&lt;include&gt;&gt;| UC_FotosPrecios
    UC_GestProd -.->|&lt;&lt;include&gt;&gt;| UC_Stock
    UC_EnviarPedido -.->|&lt;&lt;include&gt;&gt;| UC_Carrito
    UC_VentaRapida -.->|&lt;&lt;include&gt;&gt;| UC_Stock
    UC_VentaRapida -.->|&lt;&lt;extend&gt;&gt;| UC_LibroFiado
    UC_RegistrarAbono -.->|&lt;&lt;include&gt;&gt;| UC_LibroFiado

    %% Estilos Visuales
    classDef actorStyle fill:#f8fafc,stroke:#334155,stroke-width:2px,color:#0f172a,font-weight:bold;
    classDef extActorStyle fill:#f0fdf4,stroke:#16a34a,stroke-width:2px,color:#14532d,font-weight:bold;
    classDef ucStyle fill:#eff6ff,stroke:#2563eb,stroke-width:2px,color:#1e3a8a;
```

---

## 2. Descripción de Actores

| Actor | Tipo | Descripción |
|---|---|---|
| **Microempresario / Emprendedor** | Humano (Primario) | Dueño o encargado de la micro o pequeña empresa (formal o informal). Administra su catálogo, registra ventas de mostrador, controla su fiado y consulta ingresos diarios sin complejidades contables. |
| **Cliente / Comprador** | Humano (Primario) | Persona que accede a la vitrina web del micronegocio, revisa productos/precios y realiza pedidos de manera rápida y directa. |
| **Administrador del Sistema** | Humano (Secundario) | Responsable del soporte, mantenimiento y gestión global de las microempresas registradas en la plataforma Spotlight. |
| **WhatsApp / Billeteras Digitales** | Sistema Externo | Canales externos de interacción donde se concretan pedidos (chats de WhatsApp) y pagos electrónicos directos (Nequi, Daviplata, transferencias). |

---

## 3. Matriz de Casos de Uso por Módulo

### Módulo 1: Onboarding y Configuración Ligera
* **Registrar Microempresa / Perfil:** Permite a dueños de negocios informales y pequeños crear su perfil en minutos, sin requisitos tributarios complejos.
* **Configurar Métodos de Cobro:** Definición de números para billeteras digitales (Nequi, Daviplata, etc.), efectivo y transferencias.
* **Iniciar Sesión / Recuperar Acceso:** Mecanismo de autenticación simplificado.

### Módulo 2: Catálogo y Productos
* **Gestionar Productos / Servicios:** Alta, modificación y baja de ítems ofrecidos.
* **Cargar Fotos y Precios:** Adición visual atractiva para compradores (`<<include>>`).
* **Controlar Stock Básico:** Monitoreo elemental de inventario para evitar vender ítems agotados (`<<include>>`).
* **Compartir Catálogo Digital:** Genera enlaces optimizados para difundir la vitrina por WhatsApp, Instagram o Facebook.

### Módulo 3: Vitrina Digital y Pedidos (Cliente)
* **Explorar Vitrina Digital:** Visualización ágil de productos optimizada para dispositivos móviles.
* **Buscar y Filtrar Productos:** Búsqueda rápida por nombre o categoría.
* **Armar Lista de Compra / Carrito:** Selección de cantidades y productos de interés.
* **Enviar Pedido Directo:** Genera la orden y envía el resumen automáticamente al WhatsApp del negocio o por la web (`<<include>>` con Carrito).
* **Acordar Método de Entrega o Retiro:** Coordinación de entrega a domicilio o recogida en el local.

### Módulo 4: Operaciones Diarias y Libro de Fiado
* **Registrar Venta Rápida (Mostrador):** Registro en segundos de ventas presenciales con actualización inmediata de stock.
* **Gestionar Libro de Fiado:** Registro de clientes de confianza con cuentas pendientes por cobrar (`<<extend>>` de Venta Rápida cuando no pagan de contado).
* **Registrar Abonos a Deudas:** Registro de pagos parciales o totales de clientes deudores (`<<include>>` con Libro de Fiado).

### Módulo 5: Finanzas y Métricas Simples
* **Consultar Balance Diario:** Vista resumida de ingresos y gastos del día en lenguaje directo y claro.
* **Visualizar Productos Más Vendidos:** Identificación de los artículos con mayor rotación.

### Módulo 6: Administración de Plataforma
* **Supervisar Cuentas de Negocios:** Monitoreo del estado de las cuentas activas.
* **Soporte Técnico y Mantenimiento:** Resolución de dudas y estabilidad de la plataforma.
