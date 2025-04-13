describe('Cek fungsi halaman jenis tugas akhir', () => {
  it('Cek perilaku sistem jika membuka halaman data jenis tugas akhir', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-type-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-type-management')
    })
  })

  it('Cek perilaku sistem jika menyaring data jenis tugas akhir', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-type-admin"]').click();


    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-type-management')
    })

    cy.get('[data-cy="input-type-name"]').type('Skripsi')

    cy.contains('tr', 'Skripsi').should('exist');
  })

  it('Cek perilaku sistem jika menambah data jenis tugas akhir', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-type-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-type-management')
    })

    cy.get('[data-cy="btn-link-add-type"]').click();

    cy.get('[data-cy="input-type"]').type('Test Add Data')
    cy.get('[data-cy="btn-submit-store"]').click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-type-management')
    })

    cy.contains('Data Jenis Tugas Akhir Ditambahkan');
  })

  it('Cek perilaku sistem jika menambah data jenis tugas akhir dengan data nama jenis yang sudah digunakan', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-type-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-type-management')
    })

    cy.get('[data-cy="btn-link-add-type"]').click();

    cy.get('[data-cy="input-type"]').type('Test Add Data')
    cy.get('[data-cy="btn-submit-store"]').click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-type-management')
    })

    cy.contains('Data Jenis Tugas Akhir Test Add Data Telah Ditambahkan')
  })

  it('Cek perilaku sistem jika edit data jenis tugas akhir', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-type-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-type-management')
    })

    cy.get('.table').find('.btn-edit').first().click();

    cy.get('[data-cy="input-type-edit"]').type('Edit Jenis')
    cy.get('[data-cy="btn-submit-update"]').click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-type-management')
    })

    cy.contains('Data Jenis Tugas Akhir Diperbarui');
  })

  it('Cek perilaku sistem jika hapus data jenis tugas akhir', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-type-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-type-management')
    })

    cy.get('.table').find('.btn-delete').first().click();

    cy.get('[data-cy="btn-delete-confirm"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-type-management')
    })

    cy.contains('Data Jenis Tugas Akhir Dihapus');
  })
})
