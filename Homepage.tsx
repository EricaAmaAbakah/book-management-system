import {
  BookOpen,
  Search,
  Calendar,
  Users,
  Coffee,
  Wifi,
  Clock,
  MapPin,
  Star,
  Heart,
  ArrowRight,
  BookMarked,
  Headphones,
  Monitor,
} from "lucide-react"

export default function Component() {
  return (
    <div className="gradient-bg">
      {/* Header */}
      <header className="header">
        <div className="container">
          <div className="header-content">
            <div className="logo">
              <div className="logo-icon">
                <BookOpen />
              </div>
              <div className="logo-text">
                <h1>Serenity Library</h1>
                <p>Where stories come alive</p>
              </div>
            </div>
            <nav className="nav">
              <a href="#">Home</a>
              <a href="#">Catalog</a>
              <a href="#">Events</a>
              <a href="#">Services</a>
              <a href="#">About</a>
            </nav>
            <button className="btn btn-primary">My Account</button>
          </div>
        </div>
      </header>

      {/* Hero Section */}
      <section className="hero">
        <div className="container">
          <h2>
            Discover Your Next
            <br />
            <span className="hero-highlight">Adventure</span>
          </h2>
          <p>
            Explore thousands of books, digital resources, and cozy reading spaces
            <br />
            in our beautiful community library
          </p>

          {/* Search Bar */}
          <div className="search-container">
            <Search className="search-icon" />
            <input type="text" placeholder="Search for books, authors, or topics..." className="search-input" />
            <button className="btn btn-primary search-btn">Search</button>
          </div>

          {/* Quick Stats */}
          <div className="stats-grid">
            <div className="stat-card">
              <div className="stat-number blue">50K+</div>
              <div className="stat-label">Books Available</div>
            </div>
            <div className="stat-card">
              <div className="stat-number cyan">15K+</div>
              <div className="stat-label">Digital Resources</div>
            </div>
            <div className="stat-card">
              <div className="stat-number teal">200+</div>
              <div className="stat-label">Events Monthly</div>
            </div>
            <div className="stat-card">
              <div className="stat-number light-blue">24/7</div>
              <div className="stat-label">Online Access</div>
            </div>
          </div>
        </div>
      </section>

      {/* Featured Books */}
      <section className="section">
        <div className="container">
          <div className="section-header">
            <h3 className="section-title">Featured This Month</h3>
            <p className="section-subtitle">Handpicked recommendations from our librarians</p>
          </div>

          <div className="books-grid">
            {[
              { title: "The Midnight Library", author: "Matt Haig", rating: 4.8, genre: "Fiction" },
              { title: "Atomic Habits", author: "James Clear", rating: 4.9, genre: "Self-Help" },
              { title: "The Seven Moons", author: "Luna Rodriguez", rating: 4.7, genre: "Fantasy" },
              { title: "Ocean's Whisper", author: "Marina Blue", rating: 4.6, genre: "Romance" },
            ].map((book, index) => (
              <div key={index} className="book-card">
                <div className="book-image-container">
                  <img
                    src={`/placeholder-160x240.png?height=240&width=160&text=${encodeURIComponent(book.title)}`}
                    alt={book.title}
                    className="book-image"
                  />
                  <button className="heart-btn btn-secondary">
                    <Heart size={16} />
                  </button>
                </div>
                <div className="badge">{book.genre}</div>
                <h4 className="book-title">{book.title}</h4>
                <p className="book-author">by {book.author}</p>
                <div className="book-footer">
                  <div className="rating">
                    <Star className="star" size={16} />
                    <span className="rating-text">{book.rating}</span>
                  </div>
                  <button className="btn btn-primary">Borrow</button>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Services Section */}
      <section className="section services-bg">
        <div className="container">
          <div className="section-header">
            <h3 className="section-title">Library Services</h3>
            <p className="section-subtitle">Everything you need for learning and relaxation</p>
          </div>

          <div className="services-grid">
            {[
              {
                icon: BookMarked,
                title: "Book Lending",
                description: "Borrow physical and digital books for up to 3 weeks",
                iconClass: "blue",
              },
              {
                icon: Headphones,
                title: "Audiobooks",
                description: "Access thousands of audiobooks and podcasts",
                iconClass: "cyan",
              },
              {
                icon: Monitor,
                title: "Computer Access",
                description: "Free computer and internet access for all members",
                iconClass: "teal",
              },
              {
                icon: Coffee,
                title: "Reading Café",
                description: "Cozy café space with coffee and light snacks",
                iconClass: "blue-cyan",
              },
              {
                icon: Users,
                title: "Study Rooms",
                description: "Private and group study spaces available",
                iconClass: "cyan-teal",
              },
              {
                icon: Calendar,
                title: "Events & Workshops",
                description: "Regular book clubs, workshops, and community events",
                iconClass: "teal-blue",
              },
            ].map((service, index) => (
              <div key={index} className="service-card">
                <div className={`service-icon ${service.iconClass}`}>
                  <service.icon />
                </div>
                <h4 className="service-title">{service.title}</h4>
                <p className="service-description">{service.description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Hours & Location */}
      <section className="section">
        <div className="container">
          <div className="visit-grid">
            <div className="visit-content">
              <h3>Visit Us Today</h3>

              <div className="info-item">
                <div className="info-icon clock">
                  <Clock />
                </div>
                <div className="info-content">
                  <h4>Opening Hours</h4>
                  <p>Monday - Friday: 8:00 AM - 9:00 PM</p>
                  <p>Saturday: 9:00 AM - 6:00 PM</p>
                  <p>Sunday: 12:00 PM - 5:00 PM</p>
                </div>
              </div>

              <div className="info-item">
                <div className="info-icon location">
                  <MapPin />
                </div>
                <div className="info-content">
                  <h4>Location</h4>
                  <p>123 Bookworm Avenue</p>
                  <p>Literary District, Reading City</p>
                  <p>RC 12345</p>
                </div>
              </div>

              <div className="info-item">
                <div className="info-icon wifi">
                  <Wifi />
                </div>
                <div className="info-content">
                  <h4>Amenities</h4>
                  <p>Free WiFi • Parking Available</p>
                  <p>Wheelchair Accessible • Family Friendly</p>
                </div>
              </div>

              <button className="btn btn-primary" style={{ marginTop: "2rem" }}>
                Get Directions
                <ArrowRight size={20} />
              </button>
            </div>

            <div className="visit-image">
              <img src="/placeholder.svg?height=300&width=400&text=Library+Interior" alt="Library Interior" />
            </div>
          </div>
        </div>
      </section>

      {/* Newsletter Signup */}
      <section className="newsletter">
        <div className="container">
          <h3>Stay Connected</h3>
          <p>Get updates on new arrivals, events, and special programs</p>

          <form className="newsletter-form">
            <input type="email" placeholder="Enter your email" className="newsletter-input" />
            <button type="submit" className="btn newsletter-btn">
              Subscribe
            </button>
          </form>
        </div>
      </section>

      {/* Footer */}
      <footer className="footer">
        <div className="container">
          <div className="footer-grid">
            <div>
              <div className="footer-brand">
                <div className="footer-brand-icon">
                  <BookOpen />
                </div>
                <div>
                  <h4>Serenity Library</h4>
                  <p>Where stories come alive</p>
                </div>
              </div>
              <p className="footer-description">Your community hub for learning, discovery, and connection.</p>
            </div>

            <div>
              <h5>Quick Links</h5>
              <ul className="footer-links">
                <li>
                  <a href="#">Catalog Search</a>
                </li>
                <li>
                  <a href="#">My Account</a>
                </li>
                <li>
                  <a href="#">Renew Books</a>
                </li>
                <li>
                  <a href="#">Reserve Items</a>
                </li>
              </ul>
            </div>

            <div>
              <h5>Services</h5>
              <ul className="footer-links">
                <li>
                  <a href="#">Digital Library</a>
                </li>
                <li>
                  <a href="#">Research Help</a>
                </li>
                <li>
                  <a href="#">Book Clubs</a>
                </li>
                <li>
                  <a href="#">Children's Programs</a>
                </li>
              </ul>
            </div>

            <div>
              <h5>Contact</h5>
              <ul className="footer-links">
                <li>(555) 123-BOOK</li>
                <li>info@serenitylibrary.org</li>
                <li>123 Bookworm Avenue</li>
                <li>Literary District, RC 12345</li>
              </ul>
            </div>
          </div>

          <div className="footer-bottom">
            <p>&copy; 2024 Serenity Library. All rights reserved. Made with ❤️ for book lovers.</p>
          </div>
        </div>
      </footer>
    </div>
  )
}
