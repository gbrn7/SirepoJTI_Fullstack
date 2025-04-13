describe('Cek fungsi halaman topik tugas akhir', () => {
  it('Cek perilaku sistem jika membuka halaman data topik tugas akhir', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-topic-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-topic-management')
    })
  })

  it('Cek perilaku sistem jika menyaring data topik tugas akhir', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-topic-admin"]').click();


    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-topic-management')
    })

    cy.get('[data-cy="input-topic-name"]').type('Kecerdasan Buatan')

    cy.contains('tr', 'Kecerdasan Buatan').should('exist');
  })

  it('Cek perilaku sistem jika menambah data topik tugas akhir', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-topic-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-topic-management')
    })

    cy.get('[data-cy="btn-link-add-topic"]').click();

    cy.get('[data-cy="input-topic"]').type('Cyber Security')
    cy.get('[data-cy="btn-submit-store"]').click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-topic-management')
    })

    cy.contains('Data Topik Tugas Akhir Ditambahkan');
  })

  it('Cek perilaku sistem jika menambah data topik tugas akhir dengan data nama topik yang sudah digunakan', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-topic-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-topic-management')
    })

    cy.get('[data-cy="btn-link-add-topic"]').click();

    cy.get('[data-cy="input-topic"]').type('Cyber Security')
    cy.get('[data-cy="btn-submit-store"]').click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-topic-management')
    })

    cy.contains('Data Topik Tugas Akhir Cyber Security Telah Ditambahkan')
  })

  it('Cek perilaku sistem jika edit data topik tugas akhir', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-topic-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-topic-management')
    })

    cy.get('.table').find('.btn-edit').first().click();

    cy.get('[data-cy="input-topic-edit"]').type('Edit Topik')
    cy.get('[data-cy="btn-submit-update"]').click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-topic-management')
    })

    cy.contains('Data Topik Tugas Akhir Diperbarui');
  })

  it('Cek perilaku sistem jika hapus data topik tugas akhir', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-topic-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-topic-management')
    })

    cy.get('.table').find('.btn-delete').first().click();

    cy.get('[data-cy="btn-delete-confirm"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-topic-management')
    })

    cy.contains('Data Topik Tugas Akhir Dihapus');
  })
})
