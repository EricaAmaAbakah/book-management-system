export default function LibraryHomepage() {
  return (
    <div className="container">
      {/* Header */}
      <header className="header">
        <div className="logo">
          <div className="logo-icon">🌸</div>
          <div className="logo-text">
            <h1>Cherub Library</h1>
            <p>Save books you love ♡</p>
          </div>
        </div>
        <nav className="nav">
          <a href="/" className="nav-link active">
            🏠 Home
          </a>
          <a href="/books" className="nav-link">
            📚 Books
          </a>
          <a href="/account" className="nav-link">
            👤 Account
          </a>
          <a href="#login" className="nav-link">
            🔑 Login
          </a>
          <a href="#signup" className="nav-link">
            ✨ Sign Up
          </a>
        </nav>
      </header>

      {/* Main Content */}
      <main className="main-content">
        {/* Hero Section */}
        <section className="hero">
          <div className="hero-content">
            <div className="sanrio-decoration">
              <span className="floating-icon">🎀</span>
              <span className="floating-icon">💖</span>
              <span className="floating-icon">🌟</span>
            </div>

            <h2 className="hero-title">
              <span className="highlight">Save Any Books You'd Like Here ♡</span>
            </h2>
          </div>
        </section>
      </main>
    </div>
  )
}
